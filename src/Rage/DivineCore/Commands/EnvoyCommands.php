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


class EnvoyCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Gives players Envoy Crate");
        $this->setUsage("/env <player>");
        $this->setPermission("core.command.envoy");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.envoy")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}		
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /env <player>");
            return false;
        }
		if (!empty($args[0])) {
            $target = $this->getPlayer($args[0]);
			if ($target == null) {
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
				return false;
			}
            if ($target == true) {
			    $special = Item::get(120, 2, 1);
                $special->setCustomName("§r§a§k!!§r §l§6§lDivine §r§eEnvoy Crate");
                $special->setLore([
                '§r§6A Envoy Crate can be obtained by opening',
                '§r§6envoys on warzone',
                '§r§cTap the ground to open',
                '§r',
                '§r§a§lCONTAINS:',
                '§r',
                '§r§f§l* §r§cRazoredge I Enchant',
                '§r§f§l* §r§cLightning I Enchant',
                '§r§f§l* §r§cHallucination I Enchant',
                '§r§f§l* §r§6Soulbound I Enchant',
                '§r§f§l* §r§6Insanity VII Enchant',
                '§r§f§l* §r§6Insanity VIII Enchant',
                '§r§f§l* §r§eRare Keys 16x',
                '§r§f§l* §r§e100,000 EXP',
                '§r§f§l* §r§e150,000 EXP',
                '§r§f§l* §r§e200,000 EXP',
				'§r§f§l* §r§e250,000 EXP',
                '§r§f§l* §r§e500,000$',
				'§r§f§l* §r§e1,000,000$',
				'§r§f§l* §r§e1,500,000$',
				'§r§f§l* §r§e2,000,000$',
                '§r§f§l* §r§eCommon Enchantment Book',
                '§r§f§l* §r§eRare Enchantment Book',
				'§r§f§l* §r§eMythic Enchantment Book',
                '§r§f§l* §r§eLegendary Lucky Block 8x',
				'§r§f§l* §r§eBubonic Shard',
				'§r§f§l* §r§eSepticemic Shard',
                '§r§f§l* §r§ePneumonic Shard',
                '§r§3'
                ]);
				$target->getInventory()->addItem($special);
                $target->sendMessage("§a§l(!) §r§aYou have earned a §bDivine Envoy Crate§a!"); 
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