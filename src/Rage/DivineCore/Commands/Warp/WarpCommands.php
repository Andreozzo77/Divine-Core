<?php

namespace Rage\DivineCore\Commands\Warp;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI;

class WarpCommands extends PluginCommand{

	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Teleport to a warp");
        $this->setUsage("/warp");
        $this->setPermission("core.command.warp");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.warp")) {
	      	$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return false;
        }
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
	    $this->WarpUI($sender);
		return true;
	}
	
	/**
	 * @param WarpUI
	 * @param Player $player
     */
	public function WarpUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
		    case 0:
		    $player->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
            $player->sendMessage(TextFormat::GREEN . "Teleporting To Spawn");
		    break;	
		    case 1:
			$player->teleport($this->plugin->getServer()->getLevelByName("Mine")->getSpawnLocation(), 0, 0);
		    $player->sendMessage(TextFormat::GREEN . "Teleporting To Boss");
		    break;			
		    case 2:
			$player->teleport($this->plugin->getServer()->getLevelByName("KitPVPOverworld")->getSpawnLocation(), 0, 0);
		    $player->sendMessage(TextFormat::GREEN . "Teleporting To Warzone");
	    	$player->setFlying(false);
	    	$player->setAllowFlight(false);			
		    break;
			case 3:
			$level = $this->plugin->getServer()->getLevelByName("FactionSpawn");
            $x = -1172;
			$y = 73;
            $z = -525;
            $player->teleport(new Position($x, $y, $z, $level));
            $player->sendMessage(TextFormat::GREEN . "Teleporting to Crates Keys");
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§9§lWarps");
	    $form->setContent(TextFormat::AQUA . "§aSelect a warp");
	    $form->addButton(TextFormat::BLUE . "Spawn");
		$form->addButton(TextFormat::BLUE . "Boss");		
		$form->addButton(TextFormat::BLUE . "Warzone");
		$form->addButton(TextFormat::BLUE . "Crates");
		$form->sendToPlayer($player);
	}
}