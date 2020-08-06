<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class StaffCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Staff Commands");
        $this->setUsage("/staff <on|off|fly|list|say|help>");
        $this->setAliases(["s"]);
        $this->setPermission("core.command.staff");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.staff")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /staff <on|off|fly|list|say|help>");
            return false;
        }
		if (isset($args[0])) {
		    switch(strtolower($args[0])) {
			    case "on":
				case "c":
				$this->plugin->staffchat[$sender->getLowerCaseName()] = $sender;
				$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8]" . TextFormat::GREEN . " All messages will now go directly into Staff chat");
				return true;
				case "off":
				case "o":
				unset($this->plugin->staffchat[$sender->getLowerCaseName()]);
				$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8]" . TextFormat::RED . " All message will now go into Normal chat");
			    return true;
				case "help":
				$sender->sendMessage(TextFormat::GREEN . "§l»§r" . TextFormat::GOLD . " Staff Commands " . TextFormat::GREEN . "§l«");
				$sender->sendMessage(TextFormat::YELLOW . "/staff on/off" . TextFormat::GRAY . " - " . TextFormat::GREEN . " Staff chat enabled/disabled private message");
				$sender->sendMessage(TextFormat::YELLOW . "/staff say <msg>" . TextFormat::GRAY . " - " . TextFormat::GREEN . " Staff chat private message");
				$sender->sendMessage(TextFormat::YELLOW . "/staff fly" . TextFormat::GRAY . " - " . TextFormat::GREEN . " Fly in Survival or Adventure mode");
				$sender->sendMessage(TextFormat::YELLOW . "/staff list" . TextFormat::GRAY . " - " . TextFormat::GREEN . " Staff List Players online");
                return true;
				case "fly":
				case "flying":
				if ($sender->getAllowFlight() === false) {
                    $sender->setAllowFlight(true);
				    $sender->setFlying(true);
					$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8]" . TextFormat::GREEN . " Fly mode enabled!");
                } else {
					if ($sender->getAllowFlight() === true) {
                        $sender->setAllowFlight(false);
                        $sender->setFlying(false);
						$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8]" . TextFormat::RED . " Fly mode disabled!");
					}
				}
				return true;
				case "list":
				foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
                    if ($player->hasPermission("core.command.staff")) {
						$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8] " . TextFormat::GOLD . $player->getName() . TextFormat::GREEN . " Is Online!");
					}
				}
                return true;
				case "say":
				case "s":
		        array_shift($args);
				$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8] " . TextFormat::GOLD . $sender->getName() . ": " . TextFormat::GREEN . implode(" ", $args));
				foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
					if ($player->hasPermission("core.command.staff")) {
                        if ($player !== $sender) {
							$player->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8] " . TextFormat::GOLD . $sender->getName() . ": " . TextFormat::GREEN . implode(" ", $args));
						}
					}
				}
			    return true;
			    default:
				$sender->sendMessage(TextFormat::YELLOW . "§8[§6STAFF§8]" . TextFormat::RED . " Command not found check /staff help");
			    return false;
			}
		}
	}
}