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

class LinksCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Spade Links");
        $this->setUsage("/links");
		$this->setAliases(["link"]);
        $this->setPermission("core.command.links");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.links")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->EffectidsUI($sender);
		return true;
	}

	/**
	 * @param EffectidsUI
	 * @param Player $player
     */
	public function EffectidsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function (Player $player, $data) {
           $result = $data[0];
	    });
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Links");
		$form->addLabel(TextFormat::GREEN . "Vote: " . TextFormat::YELLOW . "bit.ly/dcpevote");
		$form->addLabel(TextFormat::GREEN . "Store: " . TextFormat::YELLOW . "bit.ly/dcpestore");
		$form->addLabel(TextFormat::GREEN . "Discord: " . TextFormat::YELLOW . "bit.ly/dcpediscord");
	    $form->sendToPlayer($player);
	}
}