<?php

namespace CoreSkyblock\Commands;

use CoreSkyblock\Core;

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
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI;

class ShopCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Core $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy a stuff in Shop");
        $this->setUsage("/shop");
        $this->setPermission("core.command.shop");
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
		if (!$sender->hasPermission("core.command.shop")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->ShopUI($sender);
		return true;
	}
	
	/**
	 * @param ShopUI
	 * @param Player $player
     */
	public function ShopUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->BlockUI($player);
			break;
			case 1:
			$this->ItemsUI($player);
			break;
			case 2:
			$this->FarmingUI($player);
			break;
			case 3:
			$this->MaterialUI($player);
			break;
			case 4:
			$this->FlowerUI($player);
			break;
			case 5:
			$this->FoodUI($player);
			break;
			case 6:
			$this->RaidingUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Shop");
		$form->setContent(TextFormat::AQUA . "Select Stuff To Buy!");
		$form->addButton(TextFormat::BLUE . "Blocks");
		$form->addButton(TextFormat::BLUE . "Items");
		$form->addButton(TextFormat::BLUE . "Farmings");
		$form->addButton(TextFormat::BLUE . "Materials");
		$form->addButton(TextFormat::BLUE . "Flowers & Dyes");
		$form->addButton(TextFormat::BLUE . "Foods");
		$form->addButton(TextFormat::BLUE . "Other");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param BlockUI
	 * @param Player $player
     */
	public function BlockUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->OakUI($player);
			break;
			case 2:
			$this->SpruceUI($player);
			break;
			case 3:
			$this->BirchUI($player);
			break;
			case 4:
			$this->JungleUI($player);
			break;
			case 5:
			$this->AcaciaUI($player);
			break;
			case 6:
			$this->DarkUI($player);
			break;
			case 7:
			$this->DirtUI($player);
			break;
			case 8:
			$this->CoarseUI($player);
			break;
			case 9:
			$this->GrassUI($player);
			break;
			case 10:
			$this->SandUI($player);
			break;
			case 11:
			$this->RedSandUI($player);
			break;
			case 12:
			$this->ClayUI($player);
			break;
			case 13:
			$this->GlassUI($player);
			break;
			case 14:
			$this->WoolUI($player);
			break;
			case 15:
			$this->WaterUI($player);
			break;
			case 16:
			$this->LavaUI($player);
			break;
			case 17:
			$this->BlockUI2($player);
			break;
			}
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Blocks Page 1");
		$form->setContent(TextFormat::AQUA . "Select Block To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Oak Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Spruce Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Birch Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Jungle Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Acacia Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Dark Oak Wood\n§9$20");
		$form->addButton(TextFormat::GREEN . "Dirt\n§9$10");
		$form->addButton(TextFormat::GREEN . "Coarse Dirt\n§9$10");
		$form->addButton(TextFormat::GREEN . "Grass Block\n§9$10");
		$form->addButton(TextFormat::GREEN . "Sand\n§9$15");
		$form->addButton(TextFormat::GREEN . "Red Sand\n§9$20");
		$form->addButton(TextFormat::GREEN . "Clay Block\n§9$25");
		$form->addButton(TextFormat::GREEN . "Glass\n§9$20");
		$form->addButton(TextFormat::GREEN . "Wool\n§9$10");
		$form->addButton(TextFormat::GREEN . "Water\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Lava\n§9$2,000");
		$form->addButton(TextFormat::DARK_GREEN . "Next Page 2");
		$form->sendToPlayer($player);
	}
			
	/**
	 * @param BlockUI2
	 * @param Player $player
     */
	public function BlockUI2(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->BlockUI($player);
			break;
			case 1:
			$this->StoneUI($player);
			break;
			case 2:
			$this->CobbleUI($player);
			break;
			case 3:
			$this->StoneBrickUI($player);
			break;
			case 4:
			$this->BrickUI($player);
			break;
			case 5:
			$this->SandStoneUI($player);
			break;
			case 6:
			$this->RedSandStoneUI($player);
			break;
			case 7:
			$this->NetherrackUI($player);
			break;
			case 8:
			$this->NetherBrickUI($player);
			break;
			case 9:
			$this->RedNetherBrickUI($player);
			break;
			case 10:
			$this->SoulSandUI($player);
			break;
			case 11:
			$this->QuartzUI($player);
			break;
			case 12:
			$this->EndStoneUI($player);
			break;
			case 13:
			$this->PurpurUI($player);
			break;
			case 14:
			$this->PrismarineUI($player);
			break;
			case 15:
			$this->ObsidianUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Blocks Page 2");
		$form->setContent(TextFormat::AQUA . "Select Block To Buy!");
		$form->addButton(TextFormat::DARK_GREEN . "Back Page 1");
		$form->addButton(TextFormat::GREEN . "Stone\n§9$10");
		$form->addButton(TextFormat::GREEN . "Cobblestone\n§9$10");
		$form->addButton(TextFormat::GREEN . "Stone Bricks\n§9$20");
		$form->addButton(TextFormat::GREEN . "Brick Block\n§9$20");
		$form->addButton(TextFormat::GREEN . "Sandstone\n§9$20");
		$form->addButton(TextFormat::GREEN . "Red Sandstone\n§9$30");
		$form->addButton(TextFormat::GREEN . "Netherrack\n§9$10");
		$form->addButton(TextFormat::GREEN . "Nether Brick\n§9$20");
		$form->addButton(TextFormat::GREEN . "Red Nether Brick\n§9$30");
		$form->addButton(TextFormat::GREEN . "Soul Sand\n§9$20");
		$form->addButton(TextFormat::GREEN . "Quartz Block\n§9$30");
		$form->addButton(TextFormat::GREEN . "End Stone\n§9$50");
		$form->addButton(TextFormat::GREEN . "Purpur Block\n§9$60");
		$form->addButton(TextFormat::GREEN . "Prismarine\n§9$40");
		$form->addButton(TextFormat::GREEN . "Obsidian\n§9$500");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param OakUI
	 * @param Player $player
     */
    public function OakUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Oak Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(17, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Oak Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Oak Wood!");
		$form->addLabel("§aOak Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SpruceUI
	 * @param Player $player
     */
    public function SpruceUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spruce Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(17, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spruce Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spruce Wood");
		$form->addLabel("§aSpruce Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BirchUI
	 * @param Player $player
     */
    public function BirchUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Birch Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(17, 2, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Birch Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Birch Wood!");
		$form->addLabel("§aBirch Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param JungleUI
	 * @param Player $player
     */
    public function JungleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Jungle Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(17, 3, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Jungle Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Jungle Wood!");
		$form->addLabel("§aJungle Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param AcaciaUI
	 * @param Player $player
     */
    public function AcaciaUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Acacia Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(162, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Acacia Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Jungle Wood!");
		$form->addLabel("§aAcacia Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param DarkUI
	 * @param Player $player
     */
    public function DarkUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Dark Oak Wood Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(162, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Dark Oak Wood " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Dark Oak Wood!");
		$form->addLabel("§aDark Oak Wood §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param DirtUI
	 * @param Player $player
     */
    public function DirtUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Dirt Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(3, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Dirt " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Dirt!");
		$form->addLabel("§aDirt §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CoarseUI
	 * @param Player $player
     */
    public function CoarseUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Coarse Dirt Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(3, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Coarse Dirt " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Coarse Dirt!");
		$form->addLabel("§aCoarse Dirt §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param GrassUI
	 * @param Player $player
     */
    public function GrassUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Grass Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(2, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Grass Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Grass Block!");
		$form->addLabel("§aGrass Block §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SandUI
	 * @param Player $player
     */
    public function SandUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 15 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Sand Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 15 * $result;
			$item = Item::get(12, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Sand " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Sand!");
		$form->addLabel("§aSand §eCost: $15 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedSandUI
	 * @param Player $player
     */
    public function RedSandUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Red Sand Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(12, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Red Sand " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Red Sand!");
		$form->addLabel("§aRed Sand §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ClayUI
	 * @param Player $player
     */
    public function ClayUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 25 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Clay Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 25 * $result;
			$item = Item::get(82, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Clay Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Clay Block!");
		$form->addLabel("§aClay Block §eCost: $25 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param GlassUI
	 * @param Player $player
     */
    public function GlassUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Glass Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(20, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Glass " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Glass!");
		$form->addLabel("§aGlass §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param WoolUI
	 * @param Player $player
     */
    public function WoolUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Wool Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(35, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Wool " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Wool!");
		$form->addLabel("§aWool §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param WaterUI
	 * @param Player $player
     */
    public function WaterUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Water Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(8, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Water " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Water");
		$form->addLabel("§aWater §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param LavaUI
	 * @param Player $player
     */
    public function LavaUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 2000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Lava Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 2000 * $result;
			$item = Item::get(10, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Lava " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Lava");
		$form->addLabel("§aLava §eCost: $2,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param StoneUI
	 * @param Player $player
     */
    public function StoneUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Stone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(1, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Stone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Stone!");
		$form->addLabel("§aStone §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
    /**
	 * @param CobbleUI
	 * @param Player $player
     */
    public function CobbleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cobblestone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(4, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cobblestone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cobblestone!");
		$form->addLabel("§aCobblestone §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param StoneBrickUI
	 * @param Player $player
     */
    public function StoneBrickUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Stone Bricks Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(98, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Stone Bricks " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Stone Bricks!");
		$form->addLabel("§aStone Bricks §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BrickUI
	 * @param Player $player
     */
    public function BrickUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Brick Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(45, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Brick Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Brick Block!");
		$form->addLabel("§aBrick Block §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SandStoneUI
	 * @param Player $player
     */
    public function SandStoneUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Sandstone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(24, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Sandstone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Sandstone!");
		$form->addLabel("§aSandstone §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedSandStoneUI
	 * @param Player $player
     */
    public function RedSandStoneUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 30 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Red SandStone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 30 * $result;
			$item = Item::get(179, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Red SandStone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Red SandStone!");
		$form->addLabel("§aRed Sandstone §eCost: $30 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param NetherrackUI
	 * @param Player $player
     */
    public function NetherrackUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Netherrack Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(87, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Netherrack " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Netherrack!");
		$form->addLabel("§aNetherrack §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param NetherBrickUI
	 * @param Player $player
     */
    public function NetherBrickUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Nether Bricks Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(112, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Nether Bricks " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Nether Bricks!");
		$form->addLabel("§aNether Bricks §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedNetherBrickUI
	 * @param Player $player
     */
    public function RedNetherBrickUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 30 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Red Nether Bricks Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 30 * $result;
			$item = Item::get(215, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Red Nether Bricks " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Red Nether Bricks!");
		$form->addLabel("§aRed Nether Bricks §eCost: $30 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SoulSandUI
	 * @param Player $player
     */
    public function SoulSandUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Soul Sand Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(88, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Soul Sand " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Soul Sand");
		$form->addLabel("§aSoul Sand §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param QuartzUI
	 * @param Player $player
     */
    public function QuartzUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 30 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Quartz Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 30 * $result;
			$item = Item::get(155, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Quartz Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Quartz Block!");
		$form->addLabel("§aQuartz Block §eCost: $30 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EndStoneUI
	 * @param Player $player
     */
    public function EndStoneUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy End Stone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(121, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " End Stone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "End Stone!");
		$form->addLabel("§aEnd Stone §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PurpurUI
	 * @param Player $player
     */
    public function PurpurUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 60 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Purpur Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 60 * $result;
			$item = Item::get(201, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Purpur Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Purpur Block!");
		$form->addLabel("§aPurpur Block §eCost: $60 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PrismarineUI
	 * @param Player $player
     */
    public function PrismarineUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 40 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Prismarine Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 40 * $result;
			$item = Item::get(168, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Prismarine " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Prismarine!");
		$form->addLabel("§aPrismarine §eCost: $40 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ObsidianUI
	 * @param Player $player
     */
    public function ObsidianUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Obsidian Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 500 * $result;
			$item = Item::get(49, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Obsidian " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Obsidian!");
		$form->addLabel("§aObsidian §eCost: $500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BedrockUI
	 * @param Player $player
     */
    public function BedrockUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Bedrock Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50000 * $result;
			$item = Item::get(7, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Bedrock " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Bedrock!");
		$form->addLabel("§aBedrock §eCost: $50,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ItemsUI
	 * @param Player $player
     */
	public function ItemsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->CraftUI($player);
			break;
			case 2:
			$this->FurnaceUI($player);
			break;
			case 3:
			$this->AnvilUI($player);
			break;
			case 4:
			$this->BrewingUI($player);
			break;
			case 5:
			$this->EnchantmentUI($player);
			break;
			case 6:
			$this->ChestUI($player);
			break;
			case 7:
			$this->TorchUI($player);
			break;
			case 8:
			$this->SignUI($player);
			break;
			case 9:
			$this->RedTorchUI($player);
			break;
			case 10:
			$this->GlowUI($player);
			break;
			case 11:
			$this->RedLampUI($player);
			break;
			case 12:
			$this->SeaUI($player);
			break;
			case 13:
			$this->EndRodUI($player);
			break;
			case 14:
			$this->BookshelfUI($player);
			break;
			case 15:
			$this->ItemsUI2($player);
			break;
			}
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Items!");
		$form->setContent(TextFormat::AQUA . "Select Items To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Crafting Table\n§9$100");
		$form->addButton(TextFormat::GREEN . "Furnace\n§9$100");
		$form->addButton(TextFormat::GREEN . "Anvil\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Brewing Stand\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Enchantment Table\n§9$2,500");
		$form->addButton(TextFormat::GREEN . "Chest\n§9$100");
		$form->addButton(TextFormat::GREEN . "Torch\n§9$10");
		$form->addButton(TextFormat::GREEN . "Signs\n§9$100");
		$form->addButton(TextFormat::GREEN . "Redstone Torch\n§9$100");
		$form->addButton(TextFormat::GREEN . "Glowstone\n§9$200");
		$form->addButton(TextFormat::GREEN . "Redstone Lamp\n§9$300");
		$form->addButton(TextFormat::GREEN . "Sea Lantern\n§9$300");
		$form->addButton(TextFormat::GREEN . "End Rod\n§9$500");
		$form->addButton(TextFormat::GREEN . "Bookshelf\n§9$300");
		$form->addButton(TextFormat::DARK_GREEN . "Next Page 2");
		$form->sendToPlayer($player);
	}

	/**
	 * @param ItemsUI2
	 * @param Player $player
     */
	public function ItemsUI2(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ItemsUI($player);
			break;
			case 1:
			$this->ItemFrameUI($player);
			break;
			case 2:
			$this->SnowBlockUI($player);
			break;
			case 3:
			$this->FlowerPotUI($player);
			break;
			case 4:
			$this->LadderUI($player);
			break;
			case 5:
			$this->VinesUI($player);
			break;
			case 6:
			$this->EnderChestUI($player);
			break;
			case 7:
			$this->ClockUI($player);
			break;
			case 8:
			$this->CompassUI($player);
			break;
			case 9:
			$this->BookQuilUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Items!");
		$form->setContent(TextFormat::AQUA . "Select Items To Buy!");
		$form->addButton(TextFormat::DARK_GREEN . "Back To Page 1");
		$form->addButton(TextFormat::GREEN . "Item Frame\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Snow Block\n§9$100");
		$form->addButton(TextFormat::GREEN . "Flower Pot\n§9$500");
		$form->addButton(TextFormat::GREEN . "Ladder\n§9$25");
		$form->addButton(TextFormat::GREEN . "Vines\n§9$25");
		$form->addButton(TextFormat::GREEN . "Ender Chest\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Clock\n§9$100");
		$form->addButton(TextFormat::GREEN . "Compass\n§9$100");
		$form->addButton(TextFormat::GREEN . "Book & Quil\n§9$100");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CraftUI
	 * @param Player $player
     */
    public function CraftUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Crafting Table Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(58, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Crafting Table " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Crafting Table!");
		$form->addLabel("§aCrafting Table §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param FurnaceUI
	 * @param Player $player
     */
    public function FurnaceUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Furnace Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(61, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Furnace " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Furnace!");
		$form->addLabel("§aFurnace §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param AnvilUI
	 * @param Player $player
     */
    public function AnvilUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Anvil Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(145, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Anvil " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Anvil!");
		$form->addLabel("§aAnvil §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}

	/**
	 * @param BrewingUI
	 * @param Player $player
     */
    public function BrewingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Brewing Stand Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(379, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Brewing Stand " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Brewing Stand!");
		$form->addLabel("§aBrewing Stand §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EnchantmentUI
	 * @param Player $player
     */
    public function EnchantmentUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 2500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Enchantment Table Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 2500 * $result;
			$item = Item::get(116, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Enchantment Table " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Enchantment Table!");
		$form->addLabel("§aEnchantment Table §eCost: $2,500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ChestUI
	 * @param Player $player
     */
    public function ChestUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Chest Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(54, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Chest " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Chest!");
		$form->addLabel("§aChest §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param TorchUI
	 * @param Player $player
     */
    public function TorchUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Torch Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(50, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Torch " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Torch!");
		$form->addLabel("§aTorch §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SignUI
	 * @param Player $player
     */
    public function SignUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Signs Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(323, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Signs " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Signs!");
		$form->addLabel("§aSigns §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedTorchUI
	 * @param Player $player
     */
    public function RedTorchUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Redstone Torch Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(76, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Redstone Torch " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Redstone Torch!");
		$form->addLabel("§aRedstone Torch §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param GlowUI
	 * @param Player $player
     */
    public function GlowUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 200 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Glowstone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 200 * $result;
			$item = Item::get(89, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Glowstone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Glowstone!");
		$form->addLabel("§aGlowstone §eCost: $200 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedLampUI
	 * @param Player $player
     */
    public function RedLampUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 300 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Redstone Lamp Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 300 * $result;
			$item = Item::get(89, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Redstone Lamp " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Redstone Lamp");
		$form->addLabel("§aRedstone Lamp §eCost: $300 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SeaUI
	 * @param Player $player
     */
    public function SeaUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 300 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Sea Lantern Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 300 * $result;
			$item = Item::get(169, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Sea Lantern " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Sea Lantern");
		$form->addLabel("§aSea Lantern §eCost: $300 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EndRodUI
	 * @param Player $player
     */
    public function EndRodUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy End Rod Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 500 * $result;
			$item = Item::get(208, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " End Rod " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "End Rod");
		$form->addLabel("§aEnd Rod §eCost: $500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BookshelfUI
	 * @param Player $player
     */
    public function BookshelfUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 300 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Bookshelf Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 300 * $result;
			$item = Item::get(47, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Bookshelf " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Bookshelf");
		$form->addLabel("§aBookshelf §eCost: $300 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ItemFrameUI
	 * @param Player $player
     */
    public function ItemFrameUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Item Frame Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(389, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Item Frame " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Item Frame!");
		$form->addLabel("§aItem Frame §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SnowBlockUI
	 * @param Player $player
     */
    public function SnowBlockUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Snow Block Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(80, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Snow Block " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Snow Block!");
		$form->addLabel("§aSnow Block §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}

	/**
	 * @param FlowerPotUI
	 * @param Player $player
     */
    public function FlowerPotUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Flower Pot Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 500 * $result;
			$item = Item::get(390, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Flower Pot " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Flower Pot!");
		$form->addLabel("§aFlower Pot §eCost: $500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}


	/**
	 * @param LadderUI
	 * @param Player $player
     */
    public function LadderUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 25 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Ladder Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 25 * $result;
			$item = Item::get(65, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Ladder " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Ladder!");
		$form->addLabel("§aLadder §eCost: $25 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param VinesUI
	 * @param Player $player
     */
    public function VinesUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 25 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Vines Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 25 * $result;
			$item = Item::get(106, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Vines " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Vines!");
		$form->addLabel("§aVines §eCost: $25 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EnderChestUI
	 * @param Player $player
     */
    public function EnderChestUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Ender Chest Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(130, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Ender Chest " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Ender Chest!");
		$form->addLabel("§aEnder Chest §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ClockUI
	 * @param Player $player
     */
    public function ClockUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Clock Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(347, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Clock " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Clock!");
		$form->addLabel("§aClock §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CompassUI
	 * @param Player $player
     */
    public function CompassUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Compass Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(345, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Compass " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Compass!");
		$form->addLabel("§aCompass §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BookQuilUI
	 * @param Player $player
     */
    public function BookQuilUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Book & Quil Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(386, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Book & Quil " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Book & Quil!");
		$form->addLabel("§aBook & Quil §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 5, 1);
        $form->sendToPlayer($player);
	}

	/**
	 * @param FarmingUI
	 * @param Player $player
     */
	public function FarmingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->OakSpalingUI($player);
			break;
			case 2:
			$this->SpruceSpalingUI($player);
			break;
			case 3:
			$this->BirchSpalingUI($player);
			break;
			case 4:
			$this->JungleSpalingUI($player);
			break;
			case 5:
			$this->WheatSeedsUI($player);
			break;
			case 6:
			$this->PumpkinSeedsUI($player);
			break;
			case 7:
			$this->MelonSeedsUI($player);
			break;
			case 8:
			$this->BeetSeedsUI($player);
			break;
			case 9:
			$this->CarrotUI($player);
			break;
			case 10:
			$this->PotatoUI($player);
			break;
			case 11:
			$this->SugarUI($player);
			break;
			case 12:
			$this->CactusUI($player);
			break;
			case 13:
			$this->BMushroomUI($player);
			break;
			case 14:
			$this->RMushroomUI($player);
			break;
			case 15:
			$this->NetherWartUI($player);
			break;
			case 16:
			$this->BoneMealUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Farming!");
		$form->setContent(TextFormat::AQUA . "Select Farmings To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Oak Sapling\n§9$10");
		$form->addButton(TextFormat::GREEN . "Spruce Sapling\n§9$10");
		$form->addButton(TextFormat::GREEN . "Birch Sapling\n§9$10");
		$form->addButton(TextFormat::GREEN . "Jungle Sapling\n§9$10");
		$form->addButton(TextFormat::GREEN . "Wheat Seeds\n§9$10");
		$form->addButton(TextFormat::GREEN . "Pumpkin Seeds\n§9$10");
		$form->addButton(TextFormat::GREEN . "Melon Seeds\n§9$10");
		$form->addButton(TextFormat::GREEN . "Beetroot Seeds\n§9$10");
		$form->addButton(TextFormat::GREEN . "Carrot\n§9$10");
		$form->addButton(TextFormat::GREEN . "Potato\n§9$10");
		$form->addButton(TextFormat::GREEN . "Sugar Canes\n§9$50");
		$form->addButton(TextFormat::GREEN . "Cactus\n§9$50");
		$form->addButton(TextFormat::GREEN . "Brown Mushrooms\n§9$50");
		$form->addButton(TextFormat::GREEN . "Red Mushrooms\n§9$50");
		$form->addButton(TextFormat::GREEN . "Nether Wart\n§9$50");
		$form->addButton(TextFormat::GREEN . "Bone Meal\n§9$100");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param OakSpalingUI
	 * @param Player $player
     */
    public function OakSpalingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Oak Sapling Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(6, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Oak Sapling " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Oak Sapling!");
		$form->addLabel("§aOak Sapling §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SpruceSpalingUI
	 * @param Player $player
     */
    public function SpruceSpalingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Spruce Sapling Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(6, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Spruce Sapling " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spruce Sapling!");
		$form->addLabel("§aSpruce Sapling §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BirchSpalingUI
	 * @param Player $player
     */
    public function BirchSpalingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Birch Sapling Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(6, 2, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Birch Sapling " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Birch Sapling!");
		$form->addLabel("§aBirch Sapling §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param JungleSpalingUI
	 * @param Player $player
     */
    public function JungleSpalingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Jungle Sapling Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(6, 3, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Jungle Sapling " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Jungle Sapling!");
		$form->addLabel("§aJungle Sapling §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param WheatSeedsUI
	 * @param Player $player
     */
    public function WheatSeedsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Wheat Seeds Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(295, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Wheat Seeds " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Wheat Seeds!");
		$form->addLabel("§aWheat Seeds §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PumpkinSeedsUI
	 * @param Player $player
     */
    public function PumpkinSeedsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Pumpkin Seeds Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(361, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Pumpkin Seeds " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Pumpkin Seeds!");
		$form->addLabel("§aPumpkin Seeds §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param MelonSeedsUI
	 * @param Player $player
     */
    public function MelonSeedsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Melon Seeds Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(362, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Melon Seeds " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Melon Seeds!");
		$form->addLabel("§aMelon Seeds §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BeetSeedsUI
	 * @param Player $player
     */
    public function BeetSeedsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Beetroot Seeds Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(458, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Beetroot Seeds " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Beetroot Seeds!");
		$form->addLabel("§aBeetroot Seeds §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CarrotUI
	 * @param Player $player
     */
    public function CarrotUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Carrot Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(391, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Carrot " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Carrot!");
		$form->addLabel("§aCarrot §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PotatoUI
	 * @param Player $player
     */
    public function PotatoUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Potato Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(392, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Potato " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Potato!");
		$form->addLabel("§aPotato §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param SugarUI
	 * @param Player $player
     */
    public function SugarUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Sugar Canes Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(338, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Sugar Canes " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Sugar Canes!");
		$form->addLabel("§aSugar Canes §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CactusUI
	 * @param Player $player
     */
    public function CactusUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cactus Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(81, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cactus " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cactus!");
		$form->addLabel("§aCactus §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BMushroomUI
	 * @param Player $player
     */
    public function BMushroomUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Brown Mushrooms Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(39, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Brown Mushrooms " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Brown Mushrooms!");
		$form->addLabel("§aBrown Mushrooms §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RMushroomUI
	 * @param Player $player
     */
    public function RMushroomUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Red Mushrooms Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(40, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Red Mushrooms " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Red Mushrooms!");
		$form->addLabel("§aRed Mushrooms §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param NetherWartUI
	 * @param Player $player
     */
    public function NetherWartUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Nether Wart Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(372, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Nether Wart " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Nether Wart!");
		$form->addLabel("§aNether Wart §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BoneMealUI
	 * @param Player $player
     */
    public function BoneMealUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Bone Meal Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(351, 15, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Bone Meal " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Bone Meal!");
		$form->addLabel("§aBone Meal §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 300, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param MaterialUI
	 * @param Player $player
     */
	public function MaterialUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->CoalUI($player);
			break;
			case 2:
			$this->IronUI($player);
			break;
			case 3:
			$this->LapisUI($player);
			break;
			case 4:
			$this->RedstoneUI($player);
			break;
			case 5:
			$this->GoldUI($player);
			break;
			case 6:
			$this->DiamondUI($player);
			break;
			case 7:
			$this->EmeraldUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Material");
		$form->setContent(TextFormat::AQUA . "Select Stuff To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Coal\n§9$50");
		$form->addButton(TextFormat::GREEN . "Iron Ingot\n§9$100");
		$form->addButton(TextFormat::GREEN . "Lapis Lazuli\n§9$75");
		$form->addButton(TextFormat::GREEN . "Redstone\n§9$75");
		$form->addButton(TextFormat::GREEN . "Gold Ingot\n§9$250");
		$form->addButton(TextFormat::GREEN . "Diamond\n§9$500");
		$form->addButton(TextFormat::GREEN . "Emerald\n§9$1,000");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CoalUI
	 * @param Player $player
     */
    public function CoalUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Coal Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(263, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Coal " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Coal");
		$form->addLabel("§aCoal §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param IronUI
	 * @param Player $player
     */
    public function IronUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Iron Ingot Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(265, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Iron Ingot " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Iron Ingot");
		$form->addLabel("§aIron Ingot §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param LapisUI
	 * @param Player $player
     */
    public function LapisUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 75 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Lapis Lazuli Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 75 * $result;
			$item = Item::get(351, 4, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Lapis Lazuli " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Lapis Lazuli");
		$form->addLabel("§aLapis Lazuli §eCost: $75 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedstoneUI
	 * @param Player $player
     */
    public function RedstoneUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 75 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Redstone Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 75 * $result;
			$item = Item::get(331, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Redstone " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Redstone");
		$form->addLabel("§aRedstone §eCost: $75 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param GoldUI
	 * @param Player $player
     */
    public function GoldUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 250 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Gold Ingot Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 250 * $result;
			$item = Item::get(266, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Gold Ingot " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Gold Ingot");
		$form->addLabel("§aGold Ingot §eCost: $250 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param DiamondUI
	 * @param Player $player
     */
    public function DiamondUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Diamond Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 500 * $result;
			$item = Item::get(264, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Diamond " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Diamond");
		$form->addLabel("§aDiamond §eCost: $500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EmeraldUI
	 * @param Player $player
     */
    public function EmeraldUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Emerald Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(388, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Emerald " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Emerald");
		$form->addLabel("§aEmerald §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param FlowerUI
	 * @param Player $player
     */
	public function FlowerUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->DandelionUI($player);
			break;
			case 2:
			$this->PoppyUI($player);
			break;
			case 3:
			$this->OrchidUI($player);
			break;
			case 4:
			$this->AlliumUI($player);
			break;
			case 5:
			$this->AzureUI($player);
			break;
			case 6:
			$this->RedTulipUI($player);
			break;
			case 7:
			$this->OrangeTulipUI($player);
			break;
			case 8:
			$this->WhiteTulipUI($player);
			break;
			case 9:
			$this->PinkTulipUI($player);
			break;
			case 10:
			$this->OxeyeUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Flower & Dyes");
		$form->setContent(TextFormat::AQUA . "Select Stuff To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Dandelion\n§9$10");
		$form->addButton(TextFormat::GREEN . "Poppy\n§9$10");
		$form->addButton(TextFormat::GREEN . "Blue Orchid\n§9$10");
		$form->addButton(TextFormat::GREEN . "Allium\n§9$10");
		$form->addButton(TextFormat::GREEN . "Azure Bluet\n§9$10");
		$form->addButton(TextFormat::GREEN . "Red Tulip\n§9$10");
		$form->addButton(TextFormat::GREEN . "Orange Tulip\n§9$10");
		$form->addButton(TextFormat::GREEN . "White Tulip\n§9$10");
		$form->addButton(TextFormat::GREEN . "Pink Tulip\n§9$10");
		$form->addButton(TextFormat::GREEN . "Oxeye Daisy\n§9$10");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param DandelionUI
	 * @param Player $player
     */
    public function DandelionUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Dandelion Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(37, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Dandelion " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Dandelion");
		$form->addLabel("§aDandelion §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PoppyUI
	 * @param Player $player
     */
    public function PoppyUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Poppy Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Poppy " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Poppy");
		$form->addLabel("§aPoppy §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param OrchidUI
	 * @param Player $player
     */
    public function OrchidUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Blue Orchid Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 1, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Blue Orchid " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Blue Orchid");
		$form->addLabel("§aBlue Orchid §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param AlliumUI
	 * @param Player $player
     */
    public function AlliumUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Allium Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 2, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Allium " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Allium");
		$form->addLabel("§aAllium §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param AzureUI
	 * @param Player $player
     */
    public function AzureUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Azure Bluet Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 3, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Azure Bluet " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Azure Bluet");
		$form->addLabel("§aAzure Bluet §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RedTulipUI
	 * @param Player $player
     */
    public function RedTulipUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Red Tulip Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 4, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Red Tulip " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Red Tulip");
		$form->addLabel("§aRed Tulip §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param OrangeTulipUI
	 * @param Player $player
     */
    public function OrangeTulipUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Orange Tulip Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 5, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Orange Tulip " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Orange Tulip");
		$form->addLabel("§aOrange Tulip §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param WhiteTulipUI
	 * @param Player $player
     */
    public function WhiteTulipUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy White Tulip Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 6, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " White Tulip " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "White Tulip");
		$form->addLabel("§aWhite Tulip §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PinkTulipUI
	 * @param Player $player
     */
    public function PinkTulipUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Pink Tulip Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 7, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Pink Tulip " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Pink Tulip");
		$form->addLabel("§aPink Tulip §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param OxeyeUI
	 * @param Player $player
     */
    public function OxeyeUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Oxeye Daisy Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(38, 8, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Oxeye Daisy " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Oxeye Daisy");
		$form->addLabel("§aOxeye Daisy §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}

	/**
	 * @param FoodUI
	 * @param Player $player
     */
	public function FoodUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->CookieUI($player);
			break;
			case 2:
			$this->AppleUI($player);
			break;
			case 3:
			$this->ChickenUI($player);
			break;
			case 4:
			$this->BeefUI($player);
			break;
			case 5:
			$this->PorkUI($player);
			break;
			case 6:
			$this->PieUI($player);
			break;
			case 7:
			$this->GoldenAppleUI($player);
			break;
			case 8:
			$this->EnchantedAppleUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Foods");
		$form->setContent(TextFormat::AQUA . "Select Food To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Cookie\n§9$10");
		$form->addButton(TextFormat::GREEN . "Apple\n§9$20");
		$form->addButton(TextFormat::GREEN . "Cooked Chicken\n§9$30");
		$form->addButton(TextFormat::GREEN . "Cooked Beef\n§9$40");
		$form->addButton(TextFormat::GREEN . "Cooked Porkchop\n§9$40");
		$form->addButton(TextFormat::GREEN . "Pumpkin Pie\n§9$40");
		$form->addButton(TextFormat::GREEN . "Golden Apple\n§9$2,500");
		$form->addButton(TextFormat::GREEN . "Enchanted Golden Apple\n§9$10,000");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CookieUI
	 * @param Player $player
     */
    public function CookieUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cookie Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10 * $result;
			$item = Item::get(357, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cookie " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cookie");
		$form->addLabel("§aCookie §eCost: $10 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param AppleUI
	 * @param Player $player
     */
    public function AppleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 20 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Apple Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 20 * $result;
			$item = Item::get(260, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Apple " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Apple");
		$form->addLabel("§aApple §eCost: $20 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
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
                $cost = 30 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cooked Chicken Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 30 * $result;
			$item = Item::get(366, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cooked Chicken " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cooked Chicken");
		$form->addLabel("§aCooked Chicken §eCost: $30 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param BeefUI
	 * @param Player $player
     */
    public function BeefUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 40 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cooked Beef Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 40 * $result;
			$item = Item::get(364, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cooked Beef " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cooked Beef");
		$form->addLabel("§aCooked Beef §eCost: $40 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PorkUI
	 * @param Player $player
     */
    public function PorkUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 40 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cooked Porkchop Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 40 * $result;
			$item = Item::get(320, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cooked Porkchop " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cooked Porkchop");
		$form->addLabel("§aCooked Porkchop §eCost: $40 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param PieUI
	 * @param Player $player
     */
    public function PieUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 40 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Pumpkin Pie Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 40 * $result;
			$item = Item::get(400, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Pumpkin Pie " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Pumpkin Pie");
		$form->addLabel("§aPumpkin Pie §eCost: $40 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param GoldenAppleUI
	 * @param Player $player
     */
    public function GoldenAppleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 2500 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Golden Apple Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 2500 * $result;
			$item = Item::get(322, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Golden Apple " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Golden Apple");
		$form->addLabel("§aGolden Apple §eCost: $2,500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EnchantedAppleUI
	 * @param Player $player
     */
    public function EnchantedAppleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 10000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Enchanted Golden Apple Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 10000 * $result;
			$item = Item::get(466, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Enchanted Golden Apple " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Enchanted Golden Apple");
		$form->addLabel("§aEnchanted Golden Apple §eCost: $10,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}

	/**
	 * @param RaidingUI
	 * @param Player $player
     */
	public function RaidingUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->ShopUI($player);
			break;
			case 1:
			$this->FlintUI($player);
			break;
			case 2:
			$this->ShearUI($player);
			break;
			case 3:
			$this->EnderPearlUI($player);
			break;
			case 4:
			$this->CobWebUI($player);
			break;
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Other");
		$form->setContent(TextFormat::AQUA . "Select Other To Buy!");
		$form->addButton(TextFormat::BLACK . "Back");
		$form->addButton(TextFormat::GREEN . "Flint & Steel\n§9$100");
		$form->addButton(TextFormat::GREEN . "Shears\n§9$100");
		$form->addButton(TextFormat::GREEN . "Ender Pearl\n§9$1,000");
		$form->addButton(TextFormat::GREEN . "Cobweb\n§9$50");
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param FlintUI
	 * @param Player $player
     */
    public function FlintUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Flint & Steel Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(259, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Flint & Steel " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Flint & Steel!");
		$form->addLabel("§aFlint & Steel §eCost: $100 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 10, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param ShearUI
	 * @param Player $player
     */
    public function ShearUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 100 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Shears Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 100 * $result;
			$item = Item::get(359, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Shears " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Shears!");
		$form->addLabel("§aShears §eCost: $500 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 10, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param EnderPearlUI
	 * @param Player $player
     */
    public function EnderPearlUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 1000 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Ender Pearl Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 1000 * $result;
			$item = Item::get(368, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Ender Pearl " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Ender Pearl!");
		$form->addLabel("§aEnder Pearl §eCost: $1,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 16, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param CobWebUI
	 * @param Player $player
     */
    public function CobWebUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			if ($this->economy !== null) {
                $cost = 50 * $result;
                if (!$this->economy->reduceMoney($player, $cost)) {
                    $player->sendMessage(TextFormat::RED . "You don't have enough money to buy Cobweb Cost: " . TextFormat::GOLD . "$" . $cost);
                    return true;
				}
			}
			$cost = 50 * $result;
			$item = Item::get(30, 0, $result);
			$player->getInventory()->addItem($item);
			$player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Cobweb " . TextFormat::GREEN . "for " . TextFormat::AQUA . "Cost: $" . $cost);
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Cobweb!");
		$form->addLabel("§aCobweb §eCost: $50 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
}