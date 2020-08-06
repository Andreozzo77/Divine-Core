<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\entity\Human;
use pocketmine\entity\Zombie;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\math\Vector3;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use onebone\economyapi\EconomyAPI;

class EntityEvents implements Listener{
	
	/** @var array */
	public $plugin;
	
	public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param PlayerDeathEvent $event
     */
	public function onDeath(PlayerDeathEvent $event) : void{
		$player = $event->getPlayer();
        $entity = $event->getEntity();
        $cause = $entity->getLastDamageCause();
        if ($entity instanceof Player) {
			// Teleport Back Position
			$this->plugin->back[$entity->getLowerCaseName()] = $entity->getPosition();
		}
        if ($cause instanceof EntityDamageByEntityEvent) {
			$killer = $event->getEntity()->getLastDamageCause()->getDamager();
			if ($killer instanceof Player) {
				// Bounty Kill Wanted Player
	    		$this->claimBounty($player, $killer);
			}
		}
	}
	
	/**
     * @param Player $player
     * @param Player $killer
     */
    public function claimBounty(Player $player, Player $killer) {
		$bounty = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $money = $bounty->get("Bounty");
        if ($money !== 0) {
            EconomyAPI::getInstance()->addMoney($killer->getName(), (float)$money);
			// Bounty Wanted
            $bounty->set("Bounty", 0);
            $bounty->save();
            $this->plugin->getServer()->broadcastMessage(TextFormat::BOLD . TextFormat::YELLOW . "(!)" . TextFormat::RESET . TextFormat::YELLOW . " Bounty Wanted for " . TextFormat::GOLD . $player->getName() . TextFormat::YELLOW . " Has Been Claimed By " . TextFormat::GOLD . $killer->getName());
        }
    }
}