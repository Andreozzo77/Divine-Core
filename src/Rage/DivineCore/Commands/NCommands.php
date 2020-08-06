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

class NCommands extends PluginCommand{

	public function __construct($name, Main $plugin) {
		$this->plugin = $plugin;
		$this->console = new ConsoleCommandSender();
        parent::__construct($name, $plugin);
        $this->setDescription("Enables night vision");
        $this->setUsage("/nightvision");
		$this->setAliases(["nv"]);
        $this->setPermission("core.command.wz");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.tag")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command, buy premium rank to get access");
			return false;
		}		
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->plugin->getServer()->dispatchCommand($this->console, 'effect ' . $sender->getName() . ' night_vision 100000 5');	
		$sender->sendMessage(TextFormat::GREEN . "You enabled §bnight vision§a.");
		return true;
	}
}