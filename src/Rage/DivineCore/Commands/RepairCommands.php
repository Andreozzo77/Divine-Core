<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\item\Armor;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use onebone\economyapi\EconomyAPI;

class RepairCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;
	/** @var array */
    public $economy;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Repair items in your inventory");
        $this->setUsage("/repair <hand|all>");
        $this->setAliases(["fix"]);
        $this->setPermission("core.command.repair");
		$this->economy = EconomyAPI::getInstance();
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if(!$sender->hasPermission("core.command.repair")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
        }
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/repair <hand|all>");
            return false;
		}
		if (isset($args[0])) {
		    switch(strtolower($args[0])) {
                case "hand":
                if (!$sender->getInventory()->getItemInHand() instanceof Tool and !$sender->getInventory()->getItemInHand() instanceof Armor) {
                    $sender->sendMessage(TextFormat::RED . "This item is cannot be repair");
                    return true;
                }
                if ($this->economy !== null) {
                    $cost = 500;
                    if (!$this->economy->reduceMoney($sender, $cost)) {
                        $sender->sendMessage(TextFormat::RED . "You don't have enough money to repair the item" . TextFormat::GOLD . " Cost: $" . $cost);
                        return true;
                    }
                }
                $item = $sender->getInventory()->getItemInHand();
                $item->setDamage(0);
                $sender->getInventory()->setItemInHand($item);
                $sender->sendMessage(TextFormat::GREEN . "Successfully repaired your item for §b$" . $cost);
                return true;
                case "all":
				// Repair All In Inventory
                if ($this->economy !== null) {
                    $cost = 500000;
                    if(!$this->economy->reduceMoney($sender, $cost)) {
                        $sender->sendMessage(TextFormat::RED . "You don't have enough money to repair your inventory items" . TextFormat::GOLD . " Cost: $" . $cost);
                        return true;
                    }
                }
                foreach($sender->getInventory()->getContents() as $index => $item) {
                    if ($item instanceof Tool || $item instanceof Armor) {
                        $item = $item->setDamage(0);
                        $sender->getInventory()->setItem($index, $item);
                    }
                }
			    foreach($sender->getArmorInventory()->getContents() as $index => $item) {
                    if ($item instanceof Tool || $item instanceof Armor) {
                        $item = $item->setDamage(0);
                        $sender->getArmorInventory()->setItem($index, $item);
			    	}
				}
                $sender->sendMessage(TextFormat::GREEN . "§a§l(!) §r§aSuccessfully repaired everything, including your armor for §b $" . $cost);
                return true;
                break;
                default:
			    $sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/repair <hand|all>");
                return false;
			}
        }
    }
}