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


class SoulCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Give players Soul Crate");
        $this->setUsage("/soulc <player>");
        $this->setPermission("core.command.soul");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.soul")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}		
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /soulc <player>");
            return false;
        }
		if (!empty($args[0])) {
            $target = $this->getPlayer($args[0]);
			if ($target == null) {
                $sender->sendMessage(TextFormat::RED . "That player cannot be found");
				return false;
			}
            if ($target == true) {
			    $special = Item::get(120, 1, 1);
                $special->setCustomName("§r§a§k!!§r §l§cS§5o§du§4l §r§cCrate");
                $special->setLore([
                '§r§6A Soul Crate can be obtained by killing',
                '§r§6people on warzone or wild',
                '§r§cTap the ground to open',
                '§r',
                '§r§a§lCHANCE TO GET:',
                '§r',
                '§r§f§l* §r§e10,000 EXP',
                '§r§f§l* §r§e20,000 EXP',
                '§r§f§l* §r§e30,000 EXP',
                '§r§f§l* §r§e40,000 EXP',
                '§r§f§l* §r§e50,000 EXP',
                '§r§f§l* §r§e50,000$',
                '§r§f§l* §r§e60,000$',
				'§r§f§l* §r§e70,000$',
                '§r§f§l* §r§e80,000$',
                '§r§f§l* §r§eCommon Enchantment Book',
                '§r§f§l* §r§eRare Enchantment Book',
                '§r§f§l* §r§eLucky Block 32x',
                '§r§f§l* §r§eLucky Block 64x',
                '§r§f§l* §r§eLegendary Lucky Block 1x',
                '§r§f§l* §r§eDiamond Block 16',
                '§r§f§l* §r§eDiamond Block 32',
                '§r§f§l* §r§eCommon Keys',
                '§r§f§l* §r§eRare Keys',
                '§r§f§l* §r§eLegendary Keys',
                '§r§3'
                ]);
				$target->getInventory()->addItem($special);
                $target->sendMessage("§a§l(!) §r§aYou have earned a §bSoul Crate§a!"); 
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