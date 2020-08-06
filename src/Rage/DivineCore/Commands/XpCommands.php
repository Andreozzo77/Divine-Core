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

class XpCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Buy spawners using EXP");
        $this->setUsage("/xpshop");
		$this->setAliases(["expshop", "xs"]);
        $this->setPermission("core.command.ceshop");
		$this->plugin = $plugin;
		$this->console = new ConsoleCommandSender();
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
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§a§lConverter Menu");
		$form->addButton(TextFormat::GREEN . "§6Money §a-> §6Exp");
		$form->addButton(TextFormat::GREEN . "§6Exp §a-> §6EXP");
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
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Spawners " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $this->plugin->getServer()->dispatchCommand($player, 'skove buy ' . $result);
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "MONEY -> EXP");
		$form->addLabel("§e500§a$ §e= 1§a EXP");
        $form->addSlider("§6Amount§a" , 1, 500000, 1);
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
			$cost = 0 * $result;
			if ($player->getCurrentTotalXp() - $cost < 0) {
			    $player->sendMessage(TextFormat::RED . "You do not have enough EXP to buy Common Spawners " . TextFormat::GOLD . "EXP: " . $cost);
			} else {
			    $this->plugin->getServer()->dispatchCommand($player, 'skove sell ' . $result);	
			}
			return true;
        }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Shop");
		$form->addLabel("§a1§b EXP = §a500§b$");
        $form->addSlider("Amount" , 1, 500000, 1);
        $form->sendToPlayer($player);
	}
}