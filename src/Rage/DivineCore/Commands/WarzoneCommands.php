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
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;

class WarzoneCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
		$this->plugin = $plugin;
		$this->console = new ConsoleCommandSender();
        parent::__construct($name, $plugin);
        $this->setDescription("teleport to warzone");
        $this->setUsage("/warzone");
		$this->setAliases(["wz"]);
        $this->setPermission("core.command.wz");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$sender->teleport($this->plugin->getServer()->getLevelByName("KitPVPOverworld")->getSpawnLocation(), 0, 0);
		$sender->sendMessage(TextFormat::GREEN . "Teleporting To Warzone");
		$sender->setFlying(false);
		$sender->setAllowFlight(false);
		$this->plugin->getServer()->dispatchCommand($this->console, 'rca ' . $sender->getName() . ' l j');	
		return true;
	}
}