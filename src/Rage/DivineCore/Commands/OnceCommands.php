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

use jojoe77777\FormAPI;
use _64FF00\PurePermas\PurePerms;

class OnceCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Choose your rank");
        $this->setUsage("/once");
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
		if (!$sender->hasPermission("core.command.once")) {
			$sender->sendMessage(TextFormat::RED . "§a§l(!) §r§aYou already picked a rank.");
			return false;
		}		
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->OnceUI($sender);
		return true;
	}
	
	/**
	 * @param CeShopUI
	 * @param Player $player
     */
	public function OnceUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$this->SpadesUI($player);
			break;
			case 1:
			$this->DiamondsUI($player);
			break;
			case 2:
			$this->HeartsUI($player);
			break;
			case 3:
			$this->ClubsUI($player);
			break;					
		    }
		});
		$exp = $player->getCurrentTotalXp();
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§l§aRank Selection");
		$form->setContent(TextFormat::AQUA . "§a§lWelcome to DivineCraft S3\n§r§6Here are your selection\n§6of ranks before playing\n§c§lCHOOSE WISELY");
		$form->addButton(TextFormat::GREEN . "§l§aSpades");
		$form->addButton(TextFormat::GREEN . "§l§aDiamonds");
		$form->addButton(TextFormat::GREEN . "§l§aHearts");
		$form->addButton(TextFormat::GREEN . "§l§aClubs");		
		$form->sendToPlayer($player);
	}
	
	/**
	 * @param CommonUI
	 * @param Player $player
     */
    public function SpadesUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		    	$group = $pperms->getGroup("Spades");
			    $pperms->setGroup($player, $group);
				$player->sendMessage(TextFormat::GREEN . "Changed your permanent rank to " . TextFormat::AQUA . "Spades");
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§a§lConfirmation");
		$form->addLabel("§6In this rank, the kits are more on Armory and Defense\n§c§lAre you sure you wanted to choose this rank?");
        $form->addSlider("Amount" , 1, 2, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param UncommonUI
	 * @param Player $player
     */
    public function DiamondsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		    	$group = $pperms->getGroup("Diamonds");
			    $pperms->setGroup($player, $group);
				$player->sendMessage(TextFormat::GREEN . "Changed your permanent rank to " . TextFormat::AQUA . "Diamonds");
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§a§lConfirmation");
		$form->addLabel("§6In this rank, the kits are more on Damage and Tools Efficiency\n§c§lAre you sure you wanted to choose this rank?");
        $form->addSlider("Amount" , 1, 2, 1);
        $form->sendToPlayer($player);
	}
	
	/**
	 * @param RareUI
	 * @param Player $player
     */
    public function HeartsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		    	$group = $pperms->getGroup("Hearts");
			    $pperms->setGroup($player, $group);
				$player->sendMessage(TextFormat::GREEN . "Changed your permanent rank to " . TextFormat::AQUA . "Hearts");
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§a§lConfirmation");
		$form->addLabel("§6In this rank, the kits are more on Effect Bottles\n§c§lAre you sure you wanted to choose this rank?");
        $form->addSlider("Amount" , 1, 2, 1);
        $form->sendToPlayer($player);
	}

    public function ClubsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, array $data = null) {
        $result = $data[1];
        if ($result != null) {
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Book " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		    	$group = $pperms->getGroup("Clubs");
			    $pperms->setGroup($player, $group);
				$player->sendMessage(TextFormat::GREEN . "Changed your permanent rank to " . TextFormat::AQUA . "Clubs");
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§a§lConfirmation");
		$form->addLabel("§6In this rank, the kits are more on Enchantment Books\n§c§lAre you sure you wanted to choose this rank?");
        $form->addSlider("Amount" , 1, 2, 1);
        $form->sendToPlayer($player);
	}	
}