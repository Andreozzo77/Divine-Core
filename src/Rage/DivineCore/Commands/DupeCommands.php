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

class DupeCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
		$this->plugin = $plugin;
        parent::__construct($name, $plugin);
        $this->setDescription("Brag an item");
        $this->setUsage("/dupe");
		$this->setAliases(["dupes"]);
        $this->setPermission("core.command.brag");
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
        $item = $sender->getInventory()->getItemInHand()->getName();
		$count = $sender->getInventory()->getItemInHand()->getCount();
		$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cWANING§6 " . $sender->getName() . " §ctried to do dupe " . $item . "§r §cbut doesn't have a permission");
		return true;
	}
}