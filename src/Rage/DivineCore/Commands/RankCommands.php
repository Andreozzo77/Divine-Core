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
use pocketmine\nbt\Rank\ByteRank;
use pocketmine\nbt\Rank\StringRank;
use pocketmine\nbt\Rank\IntRank;
use pocketmine\nbt\Rank\CompoundRank;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI;
use _64FF00\PurePermas\PurePerms;

class RankCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Change your rank!");
        $this->setUsage("/rank");
		$this->setAliases(["ranks"]);		
        $this->setPermission("core.command.rank");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.rank")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->RankUI($sender);
		return true;
	}
	
	/**
	 * @param RanksUI
	 * @param Player $player
     */
	public function RankUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null) {
        $result = $data;
        if ($result === null) {
            return;
        }
		switch($result) {
			case 0:
			$pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
			$group = $pperms->getGroup("Chroma");
			$pperms->setGroup($player, $group);
			$player->sendMessage(TextFormat::GREEN . "Changed Rank To " . TextFormat::AQUA . "Chroma");
			break;
			case 1:
			$pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
			$group = $pperms->getGroup("God");
			$pperms->setGroup($player, $group);
			$player->sendMessage(TextFormat::GREEN . "Changed Rank To " . TextFormat::AQUA . "God");
			break;	
			case 2:
			$pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
			$group = $pperms->getGroup("Noctournal");
			$pperms->setGroup($player, $group);
			$player->sendMessage(TextFormat::GREEN . "Changed Rank To " . TextFormat::AQUA . "Noctournal");
			break;
			case 3:
			$pperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
			$group = $pperms->getGroup("Divine");
			$pperms->setGroup($player, $group);
			$player->sendMessage(TextFormat::GREEN . "Changed rank back to " . TextFormat::AQUA . "Divine");
			break;			
		    }
		});
		$form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Rank");
		$form->setContent(TextFormat::AQUA . "Change your rank!");
		$form->addButton(TextFormat::GREEN . "Chroma");
		$form->addButton(TextFormat::GREEN . "God");
		$form->addButton(TextFormat::GREEN . "Noctournal");
		$form->addButton(TextFormat::GREEN . "§lDefault");		
		$form->sendToPlayer($player);
	}
}