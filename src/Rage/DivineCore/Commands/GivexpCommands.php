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

class GivexpCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Gives experience to player");
        $this->setUsage("/givexp <amount> <player>");
        $this->setPermission("core.command.givexp");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.givexp")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /givexp <amount> <player>");
            return false;
        }
        if (!empty($args[0])) {
            if (!empty($args[1])) {
                $target = $this->plugin->getServer()->getPlayer($args[1]);
                if ($target == true) {
                    if (is_numeric($args[0])) {
                        if ($args[0] >= 0 && $args[0] <= 1000000000) {
                            $target->addXp($args[0]);
							$sender->sendMessage("Gave XP " . $args[0] . " to " . $target->getName());
                            $target->sendMessage("§a§l(!) §r§aYou have earned §b" . $args[0] . " §aXP");
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Please provide a number 1 - 1,00,000,000");
						}
					}
				}
                if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
				}
			}
            if (empty($args[1])) {
                if (is_numeric($args[0])) {
                    if ($args[0] >= 0 && $args[0] <= 1000000000) {
                        $sender->addXp($args[0]);
						$sender->sendMessage("§a§l(!) §r§aYou have earned §b" . $args[0] . "§aXP");
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Please provide a number 1 - 1,000,000");
					}
				}
			}
        } else {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /givexp <amount> <player>");
        }
        return true;
	}
}