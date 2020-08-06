<?php

namespace CoreSkyblock\Commands\Area;

use CoreSkyblock\Core;

use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Server;

class Area extends PluginCommand{

    /** @var Core */
	public $plugin;
	
	/** @var array */
	public $levels = [];
	/** @var Area[] */
	public $areas = [];
	/** @var bool */
	public $god = false;
	/** @var bool */
	public $edit = false;
	/** @var bool */
	public $touch = false;
	/** @var bool[] */
	public $selectingFirst = [];
	/** @var bool[] */
	public $selectingSecond = [];
	/** @var Vector3[] */
	public $firstPosition = [];
	/** @var Vector3[] */
	public $secondPosition = [];

    public function __construct($name, Core $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Allows you to manage areas");
        $this->setUsage("/area <pos1/pos2/create/list/here/flag/whitelist/delete>");
        $this->setPermission("core.command.area");
		$this->plugin = $plugin;
		if (!is_dir($plugin->getDataFolder())) {
			mkdir($plugin->getDataFolder());
		}
		if (!file_exists($plugin->getDataFolder() . "areas.json")) {
			file_put_contents($plugin->getDataFolder() . "areas.json", "[]");
		}
		if (!file_exists($plugin->getDataFolder() . "area-config.yml")) {
			$c = $plugin->getResource("area-config.yml");
			$o = stream_get_contents($c);
			fclose($c);
			file_put_contents($plugin->getDataFolder() . "area-config.yml", str_replace("DEFAULT", $plugin->getServer()->getDefaultLevel()->getName(), $o));
		}
		$data = json_decode(file_get_contents($plugin->getDataFolder() . "areas.json"), true);
		foreach($data as $datum) {
			new ProtectedArea($datum["name"], $datum["flags"], new Vector3($datum["pos1"]["0"], $datum["pos1"]["1"], $datum["pos1"]["2"]), new Vector3($datum["pos2"]["0"], $datum["pos2"]["1"], $datum["pos2"]["2"]), $datum["level"], $datum["whitelist"], $this);
		}
		$c = yaml_parse_file($plugin->getDataFolder() . "area-config.yml");
		$this->god = $c["Default"]["God"];
		$this->edit = $c["Default"]["Edit"];
		$this->touch = $c["Default"]["Touch"];
		foreach($c["Worlds"] as $level => $flags) {
			$this->levels[$level] = $flags;
		}
    }
	
	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $alias, array $args): bool{
    	if(!($sender instanceof Player)){
			$sender->sendMessage(TextFormat::RED . "Command must be used in-game.");
			return true;
		}
		if(!isset($args[0])){
			return false;
		}
		$playerName = strtolower($sender->getName());
		$action = strtolower($args[0]);
		$o = "";
		switch($action) {
			case "pos1":
				if ($sender->hasPermission("core.command.area")) {
					if (isset($this->selectingFirst[$playerName]) || isset($this->selectingSecond[$playerName])) {
						$o = TextFormat::RED . "You're already selecting a position!";
					} else {
						$this->selectingFirst[$playerName] = true;
						$o = TextFormat::GREEN . "Please place or break the first position.";
					}
				}else{
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			case "pos2":
				if ($sender->hasPermission("core.command.area")) {
					if(isset($this->selectingFirst[$playerName]) || isset($this->selectingSecond[$playerName])){
						$o = TextFormat::RED . "You're already selecting a position!";
					}else{
						$this->selectingSecond[$playerName] = true;
						$o = TextFormat::GREEN . "Please place or break the second position.";
					}
				}else{
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			case "create":
				if($sender->hasPermission("core.command.area")){
					if(isset($args[1])){
						if(isset($this->firstPosition[$playerName], $this->secondPosition[$playerName])){
							if(!isset($this->areas[strtolower($args[1])])){
								new ProtectedArea(strtolower($args[1]), ["edit" => true, "god" => false, "touch" => true], $this->firstPosition[$playerName], $this->secondPosition[$playerName], $sender->getLevel()->getName(), [$playerName], $this);
								$this->saveAreas();
								unset($this->firstPosition[$playerName], $this->secondPosition[$playerName]);
								$o = TextFormat::AQUA . "Area created!";
							}else{
								$o = TextFormat::RED . "An area with that name already exists.";
							}
						}else{
							$o = TextFormat::RED . "Please select both positions first.";
						}
					}else{
						$o = TextFormat::RED . "Please specify a name for this area.";
					}
				}else{
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			case "list":
				if($sender->hasPermission("core.command.area")){
					$o = TextFormat::AQUA . "Areas: " . TextFormat::RESET;
					$i = 0;
					foreach($this->areas as $area){
						if($area->isWhitelisted($playerName)){
							$o .= $area->getName() . " (" . implode(", ", $area->getWhitelist()) . "), ";
							$i++;
						}
					}
					if($i === 0){
						$o = "There are no areas that you can edit";
					}
				}
				break;
			case "here":
				if($sender->hasPermission("core.command.area")){
					$o = "";
					foreach($this->areas as $area){
						if($area->contains($sender->getPosition(), $sender->getLevel()->getName()) && $area->getWhitelist() !== null){
							$o .= TextFormat::AQUA . "Area " . $area->getName() . " can be edited by " . implode(", ", $area->getWhitelist());
							break;
						}
					}
					if($o === "") {
						$o = TextFormat::RED . "You are in an unknown area";
					}
				}
				break;
			case "tp":
				if (!isset($args[1])){
					$o = TextFormat::RED . "You must specify an existing Area name";
					break;
				}
				if($sender->hasPermission("core.command.area")){
					$area = $this->areas[strtolower($args[1])];
					if($area !== null && $area->isWhitelisted($playerName)){
						$levelName = $area->getLevelName();
						if(isset($levelName) && Server::getInstance()->loadLevel($levelName) != false){
							$o = TextFormat::GREEN . "You are teleporting to Area " . $args[1];
							$sender->teleport(new Position($area->getFirstPosition()->getX(), $area->getFirstPosition()->getY() + 0.5, $area->getFirstPosition()->getZ(), $area->getLevel()));
						}else{
							$o = TextFormat::RED . "The level " . $levelName . " for Area ". $args[1] ." cannot be found";
						}
					}else{
						$o = TextFormat::RED . "The Area " . $args[1] . " could not be found ";
					}
				}
				break;
			case "flag":
				if($sender->hasPermission("core.command.area")){
					if(isset($args[1])){
						if(isset($this->areas[strtolower($args[1])])){
							$area = $this->areas[strtolower($args[1])];
							if(isset($args[2])){
								if(isset($area->flags[strtolower($args[2])])){
									$flag = strtolower($args[2]);
									if(isset($args[3])){
										$mode = strtolower($args[3]);
										if($mode === "true" || $mode === "on"){
											$mode = true;
										}else{
											$mode = false;
										}
										$area->setFlag($flag, $mode);
									}else{
										$area->toggleFlag($flag);
									}
									if($area->getFlag($flag)){
										$status = "on";
									}else{
										$status = "off";
									}
									$o = TextFormat::GREEN . "Flag " . $flag . " set to " . $status . " for area " . $area->getName() . "!";
								}else{
									$o = TextFormat::RED . "Flag not found. (Flags: edit, god, touch)";
								}
							}else{
								$o = TextFormat::RED . "Please specify a flag. (Flags: edit, god, touch)";
							}
						}else{
							$o = TextFormat::RED . "Area doesn't exist.";
						}
					}else{
						$o = TextFormat::RED . "Please specify the area you would like to flag.";
					}
				}else{
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			case "delete":
				if ($sender->hasPermission("core.command.area")) {
					if (isset($args[1])) {
						if (isset($this->areas[strtolower($args[1])])) {
							$area = $this->areas[strtolower($args[1])];
							$area->delete();
							$o = TextFormat::GREEN . "Area deleted!";
						} else {
							$o = TextFormat::RED . "Area does not exist.";
						}
					} else {
						$o = TextFormat::RED . "Please specify an area to delete.";
					}
				} else {
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			case "whitelist":
				if($sender->hasPermission("core.command.area")){
					if(isset($args[1], $this->areas[strtolower($args[1])])){
						$area = $this->areas[strtolower($args[1])];
						if(isset($args[2])){
							$action = strtolower($args[2]);
							switch($action){
								case "add":
									$w = ($this->plugin->getServer()->getPlayer($args[3]) instanceof Player ? strtolower($this->plugin->getServer()->getPlayer($args[3])->getName()) : strtolower($args[3]));
									if (!$area->isWhitelisted($w)) {
										$area->setWhitelisted($w);
										$o = TextFormat::GREEN . "Player $w has been whitelisted in area " . $area->getName() . ".";
									} else {
										$o = TextFormat::RED . "Player $w is already whitelisted in area " . $area->getName() . ".";
									}
									break;
								case "list":
									$o = TextFormat::AQUA . "Area " . $area->getName() . "'s whitelist:" . TextFormat::RESET;
									foreach($area->getWhitelist() as $w){
										$o .= " $w;";
									}
									break;
								case "delete":
								case "remove":
									$w = ($this->plugin->getServer()->getPlayer($args[3]) instanceof Player ? strtolower($this->plugin->getServer()->getPlayer($args[3])->getName()) : strtolower($args[3]));
									if($area->isWhitelisted($w)){
										$area->setWhitelisted($w, false);
										$o = TextFormat::GREEN . "Player $w has been unwhitelisted in area " . $area->getName() . ".";
									}else{
										$o = TextFormat::RED . "Player $w is already unwhitelisted in area " . $area->getName() . ".";
									}
									break;
								default:
									$o = TextFormat::RED . "Please specify a valid action. Usage: /area whitelist " . $area->getName() . " <add/list/remove> [player]";
									break;
							}
						} else {
							$o = TextFormat::RED . "Please specify an action. Usage: /area whitelist " . $area->getName() . " <add/list/remove> [player]";
						}
					} else {
						$o = TextFormat::RED . "Area doesn't exist. Usage: /area whitelist <area> <add/list/remove> [player]";
					}
				} else {
					$o = TextFormat::RED . "You do not have permission to use this subcommand.";
				}
				break;
			default:
				return false;
		}
		$sender->sendMessage($o);
		return true;
    }
    
    public function saveAreas() : void{
		$areas = [];
		foreach($this->areas as $area){
			$areas[] = ["name" => $area->getName(), "flags" => $area->getFlags(), "pos1" => [$area->getFirstPosition()->getFloorX(), $area->getFirstPosition()->getFloorY(), $area->getFirstPosition()->getFloorZ()] , "pos2" => [$area->getSecondPosition()->getFloorX(), $area->getSecondPosition()->getFloorY(), $area->getSecondPosition()->getFloorZ()], "level" => $area->getLevelName(), "whitelist" => $area->getWhitelist()];
		}
		file_put_contents($this->plugin->getDataFolder() . "areas.json", json_encode($areas));
	}
	
	/**
	 * @param Entity $entity
	 *
	 * @return bool
	 */
	public function canGetHurt(Entity $entity) : bool{
		$o = true;
		$default = (isset($this->levels[$entity->getLevel()->getName()]) ? $this->levels[$entity->getLevel()->getName()]["God"] : $this->god);
		if ($default) {
			$o = false;
		}
		foreach($this->areas as $area) {
			if ($area->contains(new Vector3($entity->getX(), $entity->getY(), $entity->getZ()), $entity->getLevel()->getName())) {
				if ($default && !$area->getFlag("god")) {
					$o = true;
					break;
				}
				if ($area->getFlag("god")) {
					$o = false;
				}
			}
		}
		return $o;
	}
	/**
	 * @param Player   $player
	 * @param Position $position
	 *
	 * @return bool
	 */
	public function canEdit(Player $player, Position $position) : bool{
		if ($player->hasPermission("core.protection.area")) {
			return true;
		}
		$o = true;
		$g = (isset($this->levels[$position->getLevel()->getName()]) ? $this->levels[$position->getLevel()->getName()]["Edit"] : $this->edit);
		if ($g) {
			$o = false;
		}
		foreach($this->areas as $area) {
			if ($area->contains($position, $position->getLevel()->getName())) {
				if ($area->getFlag("edit")) {
					$o = false;
				}
				if ($area->isWhitelisted(strtolower($player->getName()))) {
					$o = true;
					break;
				}
				if (!$area->getFlag("edit") && $g) {
					$o = true;
					break;
				}
			}
		}
		return $o;
	}
	/**
	 * @param Player   $player
	 * @param Position $position
	 *
	 * @return bool
	 */
	public function canTouch(Player $player, Position $position) : bool{
		if ($player->hasPermission("core.protection.area")) {
			return true;
		}
		$o = true;
		$default = (isset($this->levels[$position->getLevel()->getName()]) ? $this->levels[$position->getLevel()->getName()]["Touch"] : $this->touch);
		if($default){
			$o = false;
		}
		foreach($this->areas as $area) {
			if ($area->contains(new Vector3($position->getX(), $position->getY(), $position->getZ()), $position->getLevel()->getName())) {
				if ($area->getFlag("touch")) {
					$o = false;
				}
				if ($area->isWhitelisted(strtolower($player->getName()))) {
					$o = true;
					break;
				}
				if (!$area->getFlag("touch") && $default) {
					$o = true;
					break;
				}
			}
		}
		return $o;
	}
}