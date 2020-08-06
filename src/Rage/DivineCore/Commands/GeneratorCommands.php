<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

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
use pocketmine\utils\TextFormat;
use pocketmine\plugin\Plugin;

use CustomEnchants\CustomEnchants\CustomEnchants;
use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;

class GeneratorCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy generators!");
        $this->setUsage("/generator");
		$this->setAliases(["gen"]);
        $this->setPermission("core.command.generator");
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
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->GenUI($sender);
		return true;
	}
	
	/**
	 * @param CeShopUI
	 * @param Player $player
     */
	public function GenUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->CoalUI($player);
			break;
			case 1:
			$this->IronUI($player);
			break;
			case 2:
			$this->GoldUI($player);
			break;
			case 3:
			$this->LapisUI($player);
			break;	
			case 4:
			$this->EmeraldUI($player);
			break;		
			case 5:
			$this->DiamondUI($player);
			break;	
			case 6:
			$this->AUTOI($player);
			break;		
			case 7:
			$this->AUTOII($player);
			break;
			case 8:
			$this->AUTOIII($player);
			break;		
			case 9:
			$this->AUTOIIII($player);
			break;	
			case 10:
			$this->AUTOIIIII($player);
			break;		
			case 11:
			$this->AUTOIIIIII($player);
			break;				
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Generator");
		$form->setContent(TextFormat::AQUA . "§6Select an Ore Generators");
		$form->addButton(TextFormat::GREEN . "§6Coal Mining Generator\n§a$500,000");
		$form->addButton(TextFormat::GREEN . "§6Iron Mining Generator\n§a$1,000,000");
		$form->addButton(TextFormat::GREEN . "§6Gold Mining Generator\n§a$2,900,000");
		$form->addButton(TextFormat::GREEN . "§6Lapiz Mining Generator\n§a$3,250,000");		
		$form->addButton(TextFormat::GREEN . "§6Emerald Mining Generator\n§a$4,000,000");	
		$form->addButton(TextFormat::GREEN . "§6Diamond Mining Generator\n§a$5,500,000");	
		$form->addButton(TextFormat::GREEN . "§6Coal Auto Generator\n§a$700,000");
		$form->addButton(TextFormat::GREEN . "§6Iron Auto Generator\n§a$1,100,000");
		$form->addButton(TextFormat::GREEN . "§6Gold Auto Generator\n§a$2,200,000");
		$form->addButton(TextFormat::GREEN . "§6Lapiz Auto Generator\n§a$3,900,000");		
		$form->addButton(TextFormat::GREEN . "§6Emerald Auto Generator\n§a$4,500,000");	
		$form->addButton(TextFormat::GREEN . "§6Diamond Auto Generator\n§a$6,000,000");			
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CommonUI
	 * @param Player $player
     */
    public function CoalUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Coal Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 500000 * $result;
			$item = Item::get(Item::BROWN_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aCoal Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aCoal Ore§7 when you place',
			'§a',
            '§r§6Tier: §eI'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Coal Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Coal");
		$form->addLabel("§aCoal Generator §eCost: $500,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param UncommonUI
	 * @param Player $player
     */
    public function IronUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Iron Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000000 * $result;
			$item = Item::get(Item::MAGENTA_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aIron Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aIron Ore§7 when you place',
			'§a',
            '§r§6Tier: §eII'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Iron Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Iron");
		$form->addLabel("§aIron Generator §eCost: $1,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RareUI
	 * @param Player $player
     */
    public function GoldUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 2900000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Gold Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 2900000 * $result;
			$item = Item::get(Item::ORANGE_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§eGold Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aGold Ore§7 when you place',
			'§a',
            '§r§6Tier: §eIII'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Gold Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Gold");
		$form->addLabel("§aGold Generator §eCost: $2,900,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}

    public function LapisUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 3250000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Lapis Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 3250000 * $result;
			$item = Item::get(Item::CYAN_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§bLapis Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aLapis Ore§7 when you place',
			'§a',
            '§r§6Tier: §eIV'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Lapis Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Lapis");
		$form->addLabel("§aGold Generator §eCost: $3,250,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function EmeraldUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 4000000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Lapis Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 4000000 * $result;
			$item = Item::get(Item::WHITE_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§2Emerald Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aEmerald Ore§7 when you place',
			'§a',
            '§r§6Tier: §eVI'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Emerald Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Emerald");
		$form->addLabel("§aEmerald Generator §eCost: $4,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function DiamondUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 5500000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Diamond Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 5500000 * $result;
			$item = Item::get(Item::PURPLE_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§bDiamond Mining Generator");
            $item->setLore([
            '§r§7A mining generator that generates',
			'§r§aDiamond Ore§7 when you place',
			'§a',
            '§r§6Tier: §eVII'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Diamond Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Diamond");
		$form->addLabel("§aDiamond Generator §eCost: $5,500,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}	
    public function AUTOI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 700000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Coal Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 700000 * $result;
			$item = Item::get(Item::BLUE_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aCoal Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aCoal Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eVIII'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Coal Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Coal");
		$form->addLabel("§aCoal Generator §eCost: $700,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}		
    public function AUTOII(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1100000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Iron Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1100000 * $result;
			$item = Item::get(Item::LIME_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aIron Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aIron Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eIX'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Iron Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Iron");
		$form->addLabel("§aIron Generator §eCost: $1,100,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}	
    public function AUTOIII(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 2200000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Gold Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 2200000 * $result;
			$item = Item::get(Item::PINK_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aGold Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aGold Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eX'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Gold Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Gold");
		$form->addLabel("§aGold Generator §eCost: $2,200,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}	
    public function AUTOIIII(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 3900000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Lapis Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 3900000 * $result;
			$item = Item::get(Item::GRAY_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aLapis Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aLapis Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eXI'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Lapis Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Lapis");
		$form->addLabel("§aLapis Generator §eCost: $3,900,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function AUTOIIIII(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 4500000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Emerald Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 4500000 * $result;
			$item = Item::get(Item::SILVER_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aEmerald Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aEmerald Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eXI'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Emerald Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Emerald");
		$form->addLabel("§aEmerald Generator §eCost: $4,500,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}	
    public function AUTOIIIIII(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 6000000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Diamond Generator Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 6000000 * $result;
			$item = Item::get(Item::RED_GLAZED_TERRACOTTA, 0, $result);
            $item->setCustomName("§r§aDiamond Auto Generator");
            $item->setLore([
            '§r§7A auto generator that generates',
			'§r§aDiamond Ore§7 place a chest above the generator to collect items',
			'§a',
            '§r§6Tier: §eXII'	
            ]);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Diamond Generator " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Diamond");
		$form->addLabel("§aDiamond Generator §eCost: $6,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}		
}