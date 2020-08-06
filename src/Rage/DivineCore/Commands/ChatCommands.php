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
use pocketmine\plugin\Plugin;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI;
use _64FF00\PureChat\PureChat;

class ChatCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Change your message color");
        $this->setUsage("/chat");
		$this->setAliases(["color"]);		
        $this->setPermission("core.command.chat");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.tag")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->TagsUI($sender);
		return true;
	}
	
	/**
	 * @param TagsUI
	 * @param Player $player
     */
	public function TagsUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§aVoter§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "VOTER");
			break;
			case 1:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§dDIVINE§a4§2LIFE§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "DIVINE4LIFE");
			break;	
			case 2:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§1Hacker§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "HACKER");
			break;	
			case 3:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§cP§6V§cP§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "PVP");
			break;	
			case 4:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§6NO§aLIFE§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "NOLIFE");
			break;	
			case 5:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§6N§cOO§6B§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "NOOB");
			break;	
			case 6:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§aHold§2The§9L§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "HOLDTHEL");
			break;	
			case 7:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§bAB§300§bSE§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "AB00SE");
			break;
			case 8:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§9EZ§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "EZ");
			break;	
			case 9:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§eKarma§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "Karma");
			break;	
			case 10:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§2GOD§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "God");
			break;	
			case 11:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§b0§30§9F§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "OOF");
			break;		
			case 12:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§aOh§2Crap§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "OhCrap");
			break;		
			case 13:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§aE§9Girl§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "EGIRL");
			break;	
			case 14:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§bE§3Boy§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "EBOY");
			break;		
			case 15:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§6TRY§eHARD§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "TRYHARD");
			break;	
			case 16:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§aSuck§9It§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "SuckIt");
			break;	
			case 17:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§5Scammer§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "Scammer");
			break;	
			case 18:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§8<§6Corona§eVirus§8>"), $player);
			$player->sendMessage(TextFormat::GREEN . "Set Tag To " . TextFormat::AQUA . "CoronaVirus");
			break;	
			case 19:
			$ppchat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
			$ppchat->setSuffix((TextFormat::AQUA . "§a"), $player);
			$player->sendMessage(TextFormat::GREEN . "§aYou removed your tag");
			break;			
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Tags");
		$form->setContent(TextFormat::AQUA . "Select tags");
		$form->addButton(TextFormat::GREEN . "VOTER");
		$form->addButton(TextFormat::GREEN . "DIVINE4LIFE");
		$form->addButton(TextFormat::GREEN . "HACKER");
		$form->addButton(TextFormat::GREEN . "PVP");	
		$form->addButton(TextFormat::GREEN . "NOLIFE");
		$form->addButton(TextFormat::GREEN . "NOOB");		
		$form->addButton(TextFormat::GREEN . "HoldTheL");
		$form->addButton(TextFormat::GREEN . "AB00SE");
		$form->addButton(TextFormat::GREEN . "EZ");
		$form->addButton(TextFormat::GREEN . "Karma");	
		$form->addButton(TextFormat::GREEN . "God");
		$form->addButton(TextFormat::GREEN . "OOF");	
		$form->addButton(TextFormat::GREEN . "OhCrap");
		$form->addButton(TextFormat::GREEN . "EGIRL");
		$form->addButton(TextFormat::GREEN . "EBOY");	
		$form->addButton(TextFormat::GREEN . "TRYHARD");	
		$form->addButton(TextFormat::GREEN . "SuckIt");
		$form->addButton(TextFormat::GREEN . "Scammer");	
		$form->addButton(TextFormat::GREEN . "CoronaVirus");		
		$form->addButton(TextFormat::GREEN . "§lRemove");			
		$form->sendToPlayer($player);
	}
}