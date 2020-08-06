<?php

namespace Rage\DivineCore\Commands\Warp;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\level\Location;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class SpawnCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Teleport to server's main spawn");
        $this->setUsage("/spawn <player>");
        $this->setPermission("core.command.spawn");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.spawn")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$target = $sender;
        if (isset($args[0])) {
            if (!$sender->hasPermission("core.command.spawn.other")) {
                $sender->sendMessage(TextFormat::RED . "You don't have permission teleport other players to spawn");
                return false;
            } else {
				$target = $this->getPlayer($args[0]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
            }
        }
        $target->teleport(Location::fromObject($this->plugin->getServer()->getDefaultLevel()->getSpawnLocation(), $this->plugin->getServer()->getDefaultLevel()));
        $target->sendMessage(TextFormat::GREEN . "Teleporting To Spawn");    
		if ($target !== $sender) {
        	$sender->sendMessage(TextFormat::GREEN . "Teleporting " . TextFormat::YELLOW . $target->getDisplayName() . TextFormat::GREEN . " To Spawn");
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