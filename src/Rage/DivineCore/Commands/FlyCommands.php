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

class FlyCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Fly in Survival or Adventure mode");
        $this->setUsage("/fly <player>");
        $this->setPermission("core.command.fly");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.fly")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$target = $sender;
        if (isset($args[0])) {
            if (!$sender->hasPermission("core.command.fly.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission to give fly at other players");
                return false;
            } else {
				$target = $this->getPlayer($args[0]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
		if ($target->getAllowFlight() === false) {
            $target->setAllowFlight(true);
			$target->setFlying(true);
            $target->sendMessage(TextFormat::YELLOW . "Fly mode enabled!");
        } else {
		    if ($target->getAllowFlight() === true) {
                $target->setAllowFlight(false);
                $target->setFlying(false);
                $target->sendMessage(TextFormat::YELLOW . "Fly mode disabled!");
			}
		}
		if ($target !== $sender) {
			if ($target->getAllowFlight() === true) {
				$sender->sendMessage(TextFormat::YELLOW . "Fly mode enabled for " . $target->getName());
			} else {
				$sender->sendMessage(TextFormat::YELLOW . "Fly mode disabled for " . $target->getName());
			}
		}
		return true;
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