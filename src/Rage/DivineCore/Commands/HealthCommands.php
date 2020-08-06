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

class HealthCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("See my health");
        $this->setUsage("/myhp");
		$this->setAliases(["hp"]);			
        $this->setPermission("core.command.hp");
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
		$sender->sendMessage("§aYour HP: §f§l" . $sender->getHealth() . "§c§lHP§f/" . $sender->getMaxHealth() . "§c§lHP");
		return true;
	}
}