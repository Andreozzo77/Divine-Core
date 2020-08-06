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

class CeShopCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy custom enchanted book with EXP");
        $this->setUsage("/ceshop");
		$this->setAliases(["cs"]);
        $this->setPermission("core.command.ceshop");
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
		$this->CeShopUI($sender);
		return true;
	}
	
	/**
	 * @param CeShopUI
	 * @param Player $player
     */
	public function CeShopUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->CommonUI($player);
			break;
			case 1:
			$this->UncommonUI($player);
			break;
			case 2:
			$this->RareUI($player);
			break;
			case 3:
			$this->MythicUI($player);
			break;	
			case 4:
			$this->SpecialUI($player);
			break;				
		    }
		});
		$exp = $player->getCurrentTotalXp();
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Custom Enchants Shop");
		$form->setContent(TextFormat::AQUA . "§bBuy Custom Enchants\n§6Your EXP: §a" . number_format($exp));
		$form->addButton(TextFormat::GREEN . "§bCommon\n§6EXP: 200,000");
		$form->addButton(TextFormat::GREEN . "§eUncommon\n§6EXP: 400,000");
		$form->addButton(TextFormat::GREEN . "§6Rare\n§9EXP: 800,000");
		$form->addButton(TextFormat::GREEN . "§cMythic\n§9EXP: 2,000,000");		
		$form->addButton(TextFormat::GREEN . "§3§lSpecial§r\n§9EXP 5,000,000");	
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CommonUI
	 * @param Player $player
     */
    public function CommonUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 200000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $common = Item::get(340, 100, $result);
                $common->setCustomName("§r§bCommon Enchantment Book");
                $common->setLore([
                '§r§7Examine to recive a random',
                '§r§bCommon §7enchantment book'
                ]);
		        $player->getInventory()->addItem($common);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Common Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Common Book");
		$form->addLabel("§aCommon Book §eEXP: $100,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function UncommonUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 400000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Uncommon Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $uncommon = Item::get(340, 101, $result);
                $uncommon->setCustomName("§r§eUncommon Enchantment Book");
                $uncommon->setLore([
                '§r§7Examine to recive a random',
                '§r§eUncommon §7enchantment book'	
                ]);
				$player->getInventory()->addItem($uncommon);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Uncommon Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Ucommon Book");
		$form->addLabel("§aUncommon Book §eEXP: $250,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function RareUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 800000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Rare Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $rare = Item::get(340, 102, $result);
                $rare->setCustomName("§r§6Rare Enchantment Book");
                $rare->setLore([
                '§r§7Examine to recive a random',
                '§r§6Rare §7enchantment book'
                ]);
				$player->getInventory()->addItem($rare);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Rare Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Rare Book");
		$form->addLabel("§aRare Book §eEXP: $500,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
    public function MythicUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 2000000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Mythic Books " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $mythic = Item::get(340, 103, $result);
                $mythic->setCustomName("§r§cMythic Enchantment Book");
                $mythic->setLore([
                '§r§7Examine to recive a random',
                '§r§cMythic §7enchantment book'
                ]);
				$player->getInventory()->addItem($mythic);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::RED . " Mythic Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Mythic Book");
		$form->addLabel("§aMythic Book §eEXP: $1,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);	
	}
    public function SpecialUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 5000000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Special Books " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $special = Item::get(340, 104, $result);
                $special->setCustomName("§r§3§lSpecial§b Enchantment Book");
                $special->setLore([
                '§r§7Examine to recive a random',
                '§r§3Special §7enchantment book'
                ]);
				$player->getInventory()->addItem($special);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::RED . " Special Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Special Book");
		$form->addLabel("§aSpecial Book §eEXP: $5,000,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);		
	}	
}