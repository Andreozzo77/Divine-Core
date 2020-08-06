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

class SpawnerShopCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy spawners using EXP");
        $this->setUsage("/spawner");
		$this->setAliases(["spawners"]);
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
		$this->SUI($sender);
		return true;
	}
	
	/**
	 * @param CeShopUI
	 * @param Player $player
     */
	public function SUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->CUI($player);
			break;
			case 1:
			$this->UUI($player);
			break;
			case 2:
			$this->RUI($player);
			break;			
		    }
		});
		$exp = $player->getCurrentTotalXp();
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Spawner Shop");
		$form->setContent(TextFormat::AQUA . "§bChoose Spawner Rarity that you wanted to buy\n§6Your EXP: §a" . number_format($exp));
		$form->addButton(TextFormat::GREEN . "§6Common Spawners\n§6EXP: 100,000");
		$form->addButton(TextFormat::GREEN . "§6Uncommon Spawners\n§6EXP: 500,000");
		$form->addButton(TextFormat::GREEN . "§6Rare\n§9EXP: 900,000");		
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CommonUI
	 * @param Player $player
     */
    public function CUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 100000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Spawners " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $w = Item::get(465, 1, $result);
                $w->setCustomName("§r§b§lCommon Spawner Examiner");
                $w->setLore([
                '§r§7Examines spawners',
				'§r§l§aCHANCE TO RECEIVE:',
				'§r§7',
				'§r§aChicken Spawners',
				'§r§aPig Spawners',
				'§r§aCow Spawners',
                '§r§a'
                ]);
		        $player->getInventory()->addItem($w);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Common Spawners " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Common Spawners");
		$form->addLabel("§aCommon Spawners price §eEXP: $100,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param UncommonUI
	 * @param Player $player
     */
    public function UUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 500000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Uncommon Spawner " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $ni = Item::get(465, 2, $result);
                $ni->setCustomName("§r§e§lUncommon Spawners Examiner");
                $ni->setLore([
                '§r§7Examines spawners',
				'§r§l§aCHANCE TO RECEIVE:',
				'§r§7',
				'§r§aEnderman Spawners',
				'§r§aSkeleton Spawners',
				'§r§aSpider Spawners',
                '§r§a'
                ]);
				$player->getInventory()->addItem($ni);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Uncommon Book " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Ucommon Book");
		$form->addLabel("§aUncommon Spawner §eEXP: 500,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);
	}
	
    public function RUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 900000 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Rare Spawner " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $a = Item::get(465, 3, $result);
                $a->setCustomName("§r§6§lRare Spawners Examiner");
                $a->setLore([
                '§r§7Examines spawners',
				'§r§l§aCHANCE TO RECEIVE:',
				'§r§7',
				'§r§aBlaze Spawners',
				'§r§aIron Golem Spawners',
				'§r§aVindicator Spawners',
                '§r§a'
                ]);
				$player->getInventory()->addItem($a);
				$player->subtractXp($cost);
			    $player->sendMessage(TextFormat::GREEN . "You have bought item"  . TextFormat::AQUA . " $result " . TextFormat::GREEN . "of" . TextFormat::AQUA . " Rare Spawners " . TextFormat::GREEN . "for " . TextFormat::AQUA . "EXP: " . $cost);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Rare Book");
		$form->addLabel("§aRare Spawners §eEXP: $900,000 §aPer §eAmount: 1");
        $form->addSlider("Amount" , 1, 64, 1);
        $form->sendToPlayer($player);	
	}	
}