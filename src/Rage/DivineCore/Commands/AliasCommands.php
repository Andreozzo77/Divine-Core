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

class AliasCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Allows users to view all the usernames one user has used");
        $this->setUsage("/alias <ips|cids> <player>");
        $this->setPermission("core.command.alias");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.alias")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if (count($args) < 1) {
			$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/alias <ips|cids> <player>");
            return false;
        }
		if (isset($args[0])) {
		    switch(strtolower($args[0])) {
				case "address":
				case "ip":
				case "ips":
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /alias ips <player>");
                    return false;
				}
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
				// Alias IP Address
				$ip = $target->getAddress();
				$file = new Config($this->plugin->getDataFolder() . "alias/ip/" . $ip . ".txt", Config::ENUM);
				$names = $file->getAll(true);
				$names = implode(', ', $names);
				$sender->sendMessage(TextFormat::BLUE . "[Alias] Showing IP Address of " . $target->getName());
				$sender->sendMessage(TextFormat::GREEN . "[Alias] " . $names);
				return true;
				case "client":
				case "cid":
				case "cids":
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /alias cids <player>");
                    return false;
				}
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
				// Alias Client ID
				$cid = $target->getClientId();
				$file = new Config($this->plugin->getDataFolder() . "alias/cid/" . $cid . ".txt", Config::ENUM);
				$names = $file->getAll(true);
				$names = implode(', ', $names);
				$sender->sendMessage(TextFormat::BLUE . "[Alias] Showing Client ID of " . $target->getName());
				$sender->sendMessage(TextFormat::GREEN . "[Alias] " . $names);
				return true;
				default:
				$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/alias <ips|cids> <player>");
			    return false;
			}
		}
	}
	
	/**
     * @param string $player
     * @return null|Player
     */
    public function getPlayer($player): ?Player{
        if (!Player::isValidUserName($player)) {
            return null;
        }
        $player = strtolower($player);
        $found = null;
        foreach($this->plugin->getServer()->getOnlinePlayers() as $target) {
            if (strtolower(TextFormat::clean($target->getDisplayName(), true)) === $player || strtolower($target->getName()) === $player) {
                $found = $target;
                break;
            }
        }
        if (!$found) {
            $found = ($f = $this->plugin->getServer()->getPlayer($player)) === null ? null : $f;
        }
        if (!$found) {
            $delta = PHP_INT_MAX;
            foreach($this->plugin->getServer()->getOnlinePlayers() as $target) {
                if (stripos(($name = TextFormat::clean($target->getDisplayName(), true)), $player) === 0) {
                    $curDelta = strlen($name) - strlen($player);
                    if ($curDelta < $delta) {
                        $found = $target;
                        $delta = $curDelta;
                    }
                    if ($curDelta === 0) {
                        break;
                    }
                }
            }
        }
        return $found;
    }
}