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
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI;

class VersionCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Version servers");
        $this->setUsage("/version");
        $this->setAliases(["ver"]);
        $this->setPermission("core.command.version");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.version")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage("This server is running " . $sender->getServer()->getName() . " " . $sender->getServer()->getPocketMineVersion() . " for Minecraft: Bedrock Edition " . $sender->getServer()->getVersion() . " (protocol version 389)");
			return false;
		}
		$this->VersionUI($sender);
		return true;
	}
	
	/**
	 * @param VersionUI
	 * @param Player $player
     */
	public function VersionUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function (Player $player, $data) {
           $result = $data[0];
	    });
		
		$runing = $player->getServer()->getName();
		$pmmpver = $player->getServer()->getPocketMineVersion();
		$mcpever = $player->getServer()->getVersion();
		// UI System Version Server
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Version Server");
	    $form->addLabel(TextFormat::GREEN . "Server Runing: " . TextFormat::AQUA . $runing . " " . $pmmpver);
	    $form->addLabel(TextFormat::GREEN . "MCPE Version: " . TextFormat::AQUA . $mcpever);
		$form->addLabel(TextFormat::GREEN . "Protocol: " . TextFormat::AQUA . "Version 389");
	    $form->sendToPlayer($player);
	}
}