<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use Rage\DivineCore\Tiles\MobSpawner;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Durable;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use onebone\economyapi\EconomyAPI;

class SpawnerCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy spawner mobs");
        $this->setUsage("/spawner");
        $this->setPermission("core.command.spawner");
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
		if (!$sender->hasPermission("core.command.spawner")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->SpawnerUI($sender);
		return true;
	}
	
	/**
	 * @param SpawnerUI
	 * @param Player $player
     */
	public function SpawnerUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ChickenUI($player);
			break;
			case 1:
			$this->ZombieUI($player);
			break;
			case 2:
			$this->PigUI($player);
			break;
			case 3:
			$this->CreeperUI($player);
			break;
			case 4:
			$this->IronGolemUI($player);
			break;
			case 5:
			$this->SkeletonUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Shop");
		$form->setContent(TextFormat::AQUA . "Select Spawner To Buy!");
		$form->addButton(TextFormat::GREEN . "Spawner Chicken\n§9$50,000");
		$form->addButton(TextFormat::GREEN . "Spawner Zombie\n§9$100,000");
		$form->addButton(TextFormat::GREEN . "Spawner Pig\n§9$150,000");
		$form->addButton(TextFormat::GREEN . "Spawner Creeper\n§9$300,000");
		$form->addButton(TextFormat::GREEN . "Spawner Iron Golem\n§9$600,000");
		$form->addButton(TextFormat::GREEN . "Spawner Skeleton\n§9$1,000,000");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param ChickenUI
	 * @param Player $player
     */
    public function ChickenUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Chicken Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 50000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Chicken");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 580));
			$nbt->setTag(new IntTag("EntityId", 10));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Chicken " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Chicken");
		$form->addLabel("§aSpawner Chicken §eCost: $50,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ZombieUI
	 * @param Player $player
     */
    public function ZombieUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Zombie Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 100000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Zombie");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 600));
			$nbt->setTag(new IntTag("EntityId", 32));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Zombie " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Zombie");
		$form->addLabel("§aSpawner Zombie §eCost: $100,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PigUI
	 * @param Player $player
     */
    public function PigUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 150000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Pig Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 150000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Pig");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 620));
			$nbt->setTag(new IntTag("EntityId", 12));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Pig " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Pig");
		$form->addLabel("§aSpawner Pig §eCost: $150,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CreeperUI
	 * @param Player $player
     */
    public function CreeperUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 300000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Creeper Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 300000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Creeper");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 620));
			$nbt->setTag(new IntTag("EntityId", 33));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Creeper " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Creeper");
		$form->addLabel("§aSpawner Creeper §eCost: $300,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param IronGolemUI
	 * @param Player $player
     */
    public function IronGolemUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 600000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Iron Golem Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 600000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Iron Golem");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 650));
			$nbt->setTag(new IntTag("EntityId", 20));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Iron Golem " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Iron Golem");
		$form->addLabel("§aSpawner Iron Golem §eCost: $600,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SkeletonUI
	 * @param Player $player
     */
    public function SkeletonUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spawner Skeleton Cost: " . TextFormat::GOLD . "$" . number_format($cost));
                    return true;
				}
			}
			$cost = 1000000 * $result;
			$item = Item::get(52, 0, $result);
			$item->setCustomName("§r§6Spawner Skeleton");
			$nbt = $item->getNamedTag();
			$nbt->setTag(new IntTag("Delay", 640));
			$nbt->setTag(new IntTag("EntityId", 34));
			$nbt->setTag(new IntTag("MaxSpawnDelay", 800));
			$nbt->setTag(new IntTag("MinSpawnDelay", 200));
			$nbt->setTag(new IntTag("SpawnCount", 4));
			$nbt->setTag(new IntTag("SpawnRange", 4));
			$item->setCompoundTag($nbt);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spawner Skeleton " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . number_format($cost));
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Skeleton");
		$form->addLabel("§aSpawner Skeleton §eCost: $1,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
}