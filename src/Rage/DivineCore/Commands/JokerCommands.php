<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Durable;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;


class JokerCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Give players Joker Crate");
        $this->setUsage("/jker <player>");
        $this->setPermission("core.command.joker");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.joker")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}		
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /jker <player>");
            return false;
        }
		if (!empty($args[0])) {
            $target = $this->getPlayer($args[0]);
			if ($target == null) {
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
				return false;
			}
            if ($target == true) {
			    $special = Item::get(120, 3, 1);
                $special->setCustomName("§r§k§d§l!§f!§d!§r §cAce of §l§6JOK§eER§r§c Crate §r§k§d§l!§f!§d!");
                $special->setLore([
                '§r§6Part of the joker set',
                '§r§6rarest item on the server',
                '§r§cTap the ground to open',
                '§r',
                '§r§a§lCHANCE TO GET:',
                '§r',
                '§r§f§l* §r§e10,000,000 EXP',
                '§r§f§l* §r§e20,000,000 EXP',
                '§r§f§l* §r§e30,000,000 EXP',
                '§r§f§l* §r§e40,000,000 EXP',
				'§r§f§l* §r§e50,000,000 EXP',
                '§r§f§l* §r§e5,000,000$',
                '§r§f§l* §r§e6,000,000$',
                '§r§f§l* §r§e7,000,000$',
				'§r§f§l* §r§e8,000,000$',
				'§r§f§l* §r§e9,000,000$',
				'§r§f§l* §r§e10,000,000$',
                '§r§f§l* §r§eInfusion Material 32x',
                '§r§f§l* §r§eCorona God Kit',
                '§r§f§l* §r§ePneumonic God Kit',
                '§r§f§l* §r§eVex Spawners 32x',
                '§r§f§l* §r§eVex Spawners 62x',
                '§r§f§l* §r§eVex Spawners 128x',
                '§r§f§l* §r§eDiamond Mining Generator 128x',
                '§r§f§l* §r§eDiamond Mining Generator 64x',
                '§r§f§l* §r§eDiamond Auto Generator 128x',
                '§r§f§l* §r§eDiamond Auto Generator 64x',
                '§r§f§l* §r§eDivine Rank',
				'§r§6Tier: §e§k!!!§r',
                '§r§3'
                ]);
				$target->getInventory()->addItem($special);
                $target->sendMessage("§a§l(!) §r§aYou have earned a §bAce Of Joker Crate§a!"); 
				$sender->sendMessage("§a§l(!) §r§aYou gave a soul crate"); 
				$this->plugin->getServer()->broadcastMessage("§8-----------------------------------");
				$this->plugin->getServer()->broadcastMessage("§l§a§l(!) §r§aA Ace Of Joker Crate has been given to §e" . $target->getName());
				$this->plugin->getServer()->broadcastMessage("§8-----------------------------------");
				$this->plugin->getServer()->broadcastTitle(TextFormat::RED . "DAMN", TextFormat::GOLD . "A Ace of Joker Crate has been given to §c" . $target->getName() . "§6!", 50, 60, 50);
				return true;
            }
		}
	}
	
	/**
     * @param string $player
     * @return null|Player
     */
    public function getPlayer($player): ?Player{
        if (!Player::isValidUserName($player)) {
            return null;
        }
        $player = strtolower($player);
        $found = null;
        foreach($this->plugin->getServer()->getOnlinePlayers() as $target) {
            if (strtolower(TextFormat::clean($target->getDisplayName(), true)) === $player || strtolower($target->getName()) === $player) {
                $found = $target;
                break;
            }
        }
        if (!$found) {
            $found = ($f = $this->plugin->getServer()->getPlayer($player)) === null ? null : $f;
        }
        if (!$found) {
            $delta = PHP_INT_MAX;
            foreach($this->plugin->getServer()->getOnlinePlayers() as $target) {
                if (stripos(($name = TextFormat::clean($target->getDisplayName(), true)), $player) === 0) {
                    $curDelta = strlen($name) - strlen($player);
                    if ($curDelta < $delta) {
                        $found = $target;
                        $delta = $curDelta;
                    }
                    if ($curDelta === 0) {
                        break;
                    }
                }
            }
        }
        return $found;
    }
}