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
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;

class NicknameCommands extends PluginCommand{

	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Change your in-game name");
        $this->setUsage("/nickname <new-name|remove> <player>");
        $this->setAliases(["nick"]);
		$this->setPermission("core.command.nick");
		$this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if (!$sender->hasPermission("core.command.nick")) {
	      	$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return false;
        }
        if (count($args) < 1) {
			$sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /nickname <new-name|remove> <player>");
            return false;
        }
		$target = $sender;
        if (isset($args[1])) {
            if (!$sender->hasPermission("core.command.nick.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission to nickname at other players");
                return false;
            } else {
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
		if (strlen($args[0]) > 16) {
            $sender->sendMessage(TextFormat::RED . "Nick must not be longer than 16 characters!");
            return false;
        }
        if (strlen($args[0]) < 3) {
            $sender->sendMessage(TextFormat::RED . "Nick must be longer than 2 characters!");
            return false;
        }
		if (strtolower($args[0]) == "off" || strtolower($args[0]) == "remove") {
			$nicks = new Config($this->plugin->getDataFolder() . "player/" . strtolower($target->getName()) . ".yml", Config::YAML);
			$nicks->set("Nickname", $target->getName());
			$nicks->save();
            $target->setDisplayName($target->getName());
            $target->setNameTag($target->getName());
            $target->sendMessage(TextFormat::GREEN . "Your Nick Have Been Removed");
			if ($target !== $sender) {
				$sender->sendMessage(TextFormat::GREEN . "Removed " . $target->getName() . " Nick");
			}
            return true;
        }
		$nicks = new Config($this->plugin->getDataFolder() . "player/" . strtolower($target->getName()) . ".yml", Config::YAML);
	    $nicks->set("Nickname", $args[0] . "~§r§d");
	    $nicks->save();
        $target->setDisplayName($args[0] . "~§r§d");
        $target->setNameTag($args[0] . "~§r§d");
        $target->sendMessage(TextFormat::GREEN . "Your Nick Has Been Set To " . TextFormat::RESET . $args[0]);
	    if ($target !== $sender) {
			$sender->sendMessage(TextFormat::GREEN . "Set " . $target->getName() . TextFormat::GREEN . " Nick Has Been Set To " . TextFormat::RESET .  $args[0]);
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