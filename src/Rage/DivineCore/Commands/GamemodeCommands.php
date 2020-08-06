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
use pocketmine\utils\TextFormat;

class GamemodeCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Change player gamemode");
        $this->setUsage("/gamemode <mode> <player>");
		$this->setAliases(["gm"]);
        $this->setPermission("core.command.gamemode");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.gamemode")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/gamemode <mode> <player>");
            return false;
		}
		$target = $sender;
        if (isset($args[1])) {
            if (!$sender->hasPermission("core.command.gamemode.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission to give gamemode at other players");
                return false;
            } else {
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
		// Gamemode Survival
		if (strtolower($args[0]) == "0" || strtolower($args[0]) == "suv" || strtolower($args[0]) == "survival") {
			$target->setGamemode(0);
			if ($target === $sender) {
				Command::broadcastCommandMessage($sender, "Set own game mode to Survival Mode");
			} else {
				$target->sendMessage("You game mode change to Survival Mode");
				Command::broadcastCommandMessage($sender, "Set " . $target->getName() . " to game mode to Survival Mode");
			}
        }
		// Gamemode Creative
		if (strtolower($args[0]) == "1" || strtolower($args[0]) == "cre" || strtolower($args[0]) == "creative") {
			$target->setGamemode(1);
			if ($target === $sender) {
				Command::broadcastCommandMessage($sender, "Set own game mode to Creative Mode");
			} else {
				$target->sendMessage("You game mode change to Creative Mode");
				Command::broadcastCommandMessage($sender, "Set " . $target->getName() . " to game mode to Creative Mode");
			}
        }
		// Gamemode Adventure
		if (strtolower($args[0]) == "2" || strtolower($args[0]) == "adv" || strtolower($args[0]) == "adventure") {
			$target->setGamemode(2);
			if ($target === $sender) {
				Command::broadcastCommandMessage($sender, "Set own game mode to Adventure Mode");
			} else {
				$target->sendMessage("You game mode change to Adventure Mode");
				Command::broadcastCommandMessage($sender, "Set " . $target->getName() . " to game mode to Adventure Mode");
			}
        }
		// Gamemode Spectator
		if (strtolower($args[0]) == "3" || strtolower($args[0]) == "spe" || strtolower($args[0]) == "spectator") {
			$target->setGamemode(3);
			if ($target === $sender) {
				Command::broadcastCommandMessage($sender, "Set own game mode to Spectator Mode");
			} else {
				$target->sendMessage("You game mode change to Spectator Mode");
				Command::broadcastCommandMessage($sender, "Set " . $target->getName() . " to game mode to Spectator Mode");
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