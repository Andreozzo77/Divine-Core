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
use pocketmine\utils\Config;

use _64FF00\PureChat\PureChat;

class SetTagCommands extends PluginCommand{

	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Set Tags to player or yourself");
        $this->setUsage("/settag <tag|remove> <player>");
		$this->setPermission("core.command.settag");
		$this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if (!$sender->hasPermission("core.command.settag")) {
	      	$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return false;
        }
        if (count($args) < 1) {
			$sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /settag <tag|remove> <player>");
            return false;
        }
		$target = $sender;
        if (isset($args[1])) {
            if (!$sender->hasPermission("core.command.settag.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission to give tag at other players");
                return false;
            } else {
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
		if (strlen($args[0]) > 12) {
            $sender->sendMessage(TextFormat::RED . "Tags must not be longer than 12 characters!");
            return false;
        }
        if (strlen($args[0]) < 3) {
            $sender->sendMessage(TextFormat::RED . "Tags must be longer than 2 characters!");
            return false;
        }
		// Tags Off
		if (strtolower($args[0]) == "off" || strtolower($args[0]) == "remove") {
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::RESET . ""), $target);
            $target->sendMessage(TextFormat::GREEN . "Your Tags Have Been Removed");
			if ($target !== $sender) {
				$sender->sendMessage(TextFormat::GREEN . "Removed " . $target->getName() . " Tags");
			}
            return true;
        }
		// Set Tags
		$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
		$ppchat->setSuffix((TextFormat::RESET . $args[0]), $target);
        $target->sendMessage(TextFormat::GREEN . "Your Tags Has Been Set To " . TextFormat::RESET . $args[0]);
		if ($target !== $sender) {
			$sender->sendMessage(TextFormat::GREEN . "Set " . $target->getName() . TextFormat::GREEN . " Nick Tags Been Set To " . TextFormat::RESET .  $args[0]);
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