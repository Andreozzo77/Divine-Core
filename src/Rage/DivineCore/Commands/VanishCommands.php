<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class VanishCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;
	/** @var array */
	public $hides;
	/** @var array */
	public $vanished;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Hide from other players");
        $this->setUsage("/vanish <player>");
        $this->setAliases(["v"]);
        $this->setPermission("core.command.vanish");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.vanish")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
    	$target = $sender;
        if (isset($args[0])) {
            if (!$sender->hasPermission("core.command.vanish.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission to vanish other players");
                return false;
            } else {
				$target = $this->getPlayer($args[0]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
	    if (!isset($this->plugin->hides[$target->getLowerCaseName()])) {
		    $target->sendMessage("You are now vanished");
		    $target->setGenericFlag(Entity::DATA_FLAG_INVISIBLE, true);
		    $this->plugin->hides[$target->getLowerCaseName()] = $sender;
	    } else {
		    $target->sendMessage("You are now visible");
		    $target->setGenericFlag(Entity::DATA_FLAG_INVISIBLE, false);
            unset($this->plugin->hides[$target->getLowerCaseName()]);
		}
        if ($target !== $sender) {
			if (!isset($this->plugin->hides[$target->getLowerCaseName()])) {
		        $sender->sendMessage($target->getName() . " is now visible");
		    } else {
			    $sender->sendMessage($target->getName() . " is now vanished");
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