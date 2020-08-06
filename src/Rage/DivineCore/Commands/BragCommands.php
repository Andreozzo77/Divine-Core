<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\Plugin;

class BragCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
		$this->plugin = $plugin;
        parent::__construct($name, $plugin);
        $this->setDescription("Brag an item");
        $this->setUsage("/brag");
		$this->setAliases(["item"]);
        $this->setPermission("core.command.brag");
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.brag")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
        $item = $sender->getInventory()->getItemInHand()->getName();
		$count = $sender->getInventory()->getItemInHand()->getCount();
		$this->plugin->getServer()->broadcastMessage("§8[§e§lBRAG§r§8] §6" . $sender->getName() . " §eis bragging §8[§r" . $item . "§r " . $count . "§r§7x§8]");
		return true;
	}
}