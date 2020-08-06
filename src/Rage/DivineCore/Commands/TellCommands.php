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

class TellCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Send private messages to other players");
        $this->setUsage("/tell <player> <message>");
		$this->setAliases(["msg", "w", "t"]);
        $this->setPermission("core.command.tell");
		$this->plugin = $plugin;
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
		if (count($args) < 1) {
			$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/tell <player> <message>");
            return false;
        }
		$name = array_shift($args);
		// Player Not Found
        $target = $this->getPlayer($name);
        if ($target == null) {
            $sender->sendMessage(TextFormat::RED . "That player cannot be found");
            return false;
        }
		// Blocked Message To Yourself
		if ($target === $sender) {
			$sender->sendMessage(TextFormat::RED . "You can't send a private message to yourself!");
			return false;
		}
		$sender->sendMessage(TextFormat::YELLOW . "§8[§3me §b-> " . $target->getDisplayName() . "§8]" . TextFormat::RESET . "§a " . implode(" ", $args));
        $msg = TextFormat::YELLOW . "§8[§3" . $sender->getDisplayName() . " §b-> §3me]" . TextFormat::RESET . "§a " . implode(" ", $args);
        if ($target instanceof Player) {
            $target->sendMessage($msg);
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