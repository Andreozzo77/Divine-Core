<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\inventory\Inventory;
use pocketmine\level\Level;
use pocketmine\nbt\NBT;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class GivekeyCommands extends PluginCommand{
	
	/** @var array */
    public $plugin;

    public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Give key tier to player");
        $this->setUsage("/givekey <tier 1-4> <player> <amount>");
        $this->setPermission("core.command.givekey");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
    	if (!$sender->hasPermission("core.command.givekey")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return false;
        }
        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey <tier 1-4> <player> <amount>");
            return false;
        }
        switch(strtolower($args[0])) {
            case "1":
			case "common":
            if (!$sender->hasPermission("core.command.givekey")) {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if (count($args) < 2) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey common <player> <amount>");
                return false;
            }
            if (isset($args[1])) {
                $player = $this->plugin->getServer()->getPlayer($args[1]);
            }
            $player = $this->plugin->getServer()->getPlayer($args[1]);
            if (!$player instanceof Player) {
                if ($player instanceof ConsoleCommandSender) {
                    $sender->sendMessage(TextFormat::RED . "Please enter a player name");
                    return false;
                }
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                return false;
            }
            if (count($args) < 3) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey common <player> <amount>");
                return false;
            }
            if (isset($args[2])) {
                $amount = intval($args[2]);
            }
            $amount = intval($args[2]);
			$item = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		    $item->set("Common_Key", $item->get("Common_Key") + $amount);
			$item->save();
			$player->sendMessage("§l§b» §r§aYou earn $amount Common Key");
            break;
			case "2":
			case "uncommon":
            if (!$sender->hasPermission("core.command.givekey")) {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if (count($args) < 2) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey uncommon <player> <amount>");
                return false;
            }
            if (isset($args[1])) {
                $player = $this->plugin->getServer()->getPlayer($args[1]);
            }
            $player = $this->plugin->getServer()->getPlayer($args[1]);
            if (!$player instanceof Player) {
                if ($player instanceof ConsoleCommandSender) {
                    $sender->sendMessage(TextFormat::RED . "Please enter a player name");
                    return false;
                }
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                return false;
            }
            if (count($args) < 3) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey uncommon <player> <amount>");
                return false;
            }
            if (isset($args[2])) {
                $amount = intval($args[2]);
            }
            $amount = intval($args[2]);
			$item = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		    $item->set("Uncommon_Key", $item->get("Uncommon_Key") + $amount);
			$item->save();
			$player->sendMessage("§l§b» §r§aYou earn $amount Uncommon Key");
            break;
			case "3":
			case "rare":
            if (!$sender->hasPermission("core.command.givekey")) {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if (count($args) < 2) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey rare <player> <amount>");
                return false;
            }
            if (isset($args[1])) {
                $player = $this->plugin->getServer()->getPlayer($args[1]);
            }
            $player = $this->plugin->getServer()->getPlayer($args[1]);
            if (!$player instanceof Player) {
                if ($player instanceof ConsoleCommandSender) {
                    $sender->sendMessage(TextFormat::RED . "Please enter a player name");
                    return false;
                }
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                return false;
            }
            if (count($args) < 3) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey rare <player> <amount>");
                return false;
            }
            if (isset($args[2])) {
                $amount = intval($args[2]);
            }
            $amount = intval($args[2]);
			$item = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		    $item->set("Rare_Key", $item->get("Rare_Key") + $amount);
			$item->save();
			$player->sendMessage("§l§b» §r§aYou earn $amount Rare Key");
            break;
			case "4":
			case "mythic":
            if (!$sender->hasPermission("core.command.givekey")) {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if (count($args) < 2) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey mythic <player> <amount>");
                return false;
            }
            if (isset($args[1])) {
                $player = $this->plugin->getServer()->getPlayer($args[1]);
            }
            $player = $this->plugin->getServer()->getPlayer($args[1]);
            if (!$player instanceof Player) {
                if ($player instanceof ConsoleCommandSender) {
                    $sender->sendMessage(TextFormat::RED . "Please enter a player name");
                    return false;
                }
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                return false;
            }
            if (count($args) < 3) {
                $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey mythic <player> <amount>");
                return false;
            }
            if (isset($args[2])) {
                $amount = intval($args[2]);
            }
            $amount = intval($args[2]);
			$item = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		    $item->set("Mythic_Key", $item->get("Mythic_Key") + $amount);
			$item->save();
			$player->sendMessage("§l§b» §r§aYou earn $amount Mythic Key");
            break;
            default:
			$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/givekey <tier 1-4> <player> <amount>");
            break;
		}
		return true;
	}
}