<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;
use _64FF00\PureChat\PureChat;
use _64FF00\PurePerms\PurePerms;

class StatsCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Player stats");
        $this->setUsage("/stats");
        $this->setPermission("core.command.stats");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.stats")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->StatsUI($sender);
		return true;
	}
	
	/**
	 * @param StatsUI
	 * @param Player $player
     */
	public function StatsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function (Player $player, $data) {
           $result = $data[0];
	    });
		$name = $player->getName();
		$ping = $player->getPing();
		$exp = $player->getCurrentTotalXp();
		$file = new Config($this->getPlugin()->getDataFolder() . "player/" . strtolower($name) . ".yml", Config::YAML);
		$prefix = $this->getPrefix($player);
		$economy = $this->getPlayerMoney($player);
		$rank = $this->getPlayerRank($player);
		// Stats Players
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Stats");
	    $form->addLabel(TextFormat::GREEN . "Name: " . TextFormat::AQUA . $name);
	    $form->addLabel(TextFormat::GREEN . "Money: " . TextFormat::AQUA . $economy);
    	$form->addLabel(TextFormat::GREEN . "EXP: " . TextFormat::AQUA . $exp);
		$form->addLabel(TextFormat::GREEN . "Rank: " . TextFormat::AQUA . $rank);
		$form->addLabel(TextFormat::GREEN . "Ping: " . TextFormat::AQUA . $ping);
		$form->addLabel(TextFormat::GREEN . "Common Key: " . TextFormat::AQUA . $file->get("Common_Key"));
		$form->addLabel(TextFormat::GREEN . "Uncommon Key: " . TextFormat::AQUA . $file->get("Uncommon_Key"));
		$form->addLabel(TextFormat::GREEN . "Rare Key: " . TextFormat::AQUA . $file->get("Rare_Key"));
		$form->addLabel(TextFormat::GREEN . "Mythic Key: " . TextFormat::AQUA . $file->get("Mythic_Key"));	
	    $form->sendToPlayer($player);
	}
	
	/**
	 * @param Player $player
	 * @return float|string
	 */
	public function getPlayerMoney(Player $player) {
		/** @var EconomyAPI $economyAPI */
		$economyAPI = $this->plugin->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		if ($economyAPI instanceof EconomyAPI) {
			return $economyAPI->myMoney($player);
		} else {
			return "Plugin not found";
		}
	}
	
	/**
	 * @param Player $player
	 * @param null   $levelName
	 * @return string
	 */
	public function getPrefix(Player $player, $levelName = null): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		if ($purePerms instanceof PurePerms) {
			$prefix = $purePerms->getUserDataMgr()->getNode($player, "prefix");
			if ($levelName === null){
				if (($prefix === null) || ($prefix === "")) {
					return "No Tag";
				}
				return (string) $prefix;
			} else {
				$worldData = $purePerms->getUserDataMgr()->getWorldData($player, $levelName);
				if (empty($worldData["prefix"]) || $worldData["prefix"] == null) {
					return "No Tag";
				}
				return $worldData["prefix"];
			}
		} else {
			return "Plugin not found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getPlayerRank(Player $player): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		if ($purePerms instanceof PurePerms){
			$group = $purePerms->getUserDataMgr()->getData($player)['group'];
			if ($group !== null) {
				return $group;
			} else {
				return "No Rank";
			}
		} else {
			return "Plugin not found";
		}
	}
}