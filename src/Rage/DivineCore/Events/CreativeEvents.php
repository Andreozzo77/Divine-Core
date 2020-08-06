<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Explosion;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

class CreativeEvents implements Listener{
	
	/** @var array */
	public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param EntityDamageEvent $event
     */
	public function onHurt(EntityDamageEvent $event) : void{
		$entity = $event->getEntity();
		if ($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
            if ($damager instanceof Player) {
                if ($damager->hasPermission("core.creative.limited")) {
					# No Need Message
				} else {
                    if ($damager->getGamemode() == 1) {
                        $damager->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Attack In Creative Mode!");
                        $event->setCancelled(true);
					}
				}
			}
		}
	}
	
	/**
     * @param InventoryPickupItemEvent $event
     */
	public function onPickup(InventoryPickupItemEvent $event) : void{
        $player = $event->getInventory()->getHolder();
        if ($player instanceof Player){
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
                if ($player->getGamemode() == 1) {
                    $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Pick Up Item In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
	}
	
	/**
     * @param PlayerDropItemEvent $event
     */
	public function onDrop(PlayerDropItemEvent $event) : void{
		$player = $event->getPlayer();
        if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
                $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Drop Item In Creative Mode!");
                $event->setCancelled(true);
			}
		}
	}

	/**
     * @param PlayerCommandPreprocessEvent $event
     */
	public function onPlayerCommand(PlayerCommandPreprocessEvent $event) : void{
		$player = $event->getPlayer();
		if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
                $msg = $event->getMessage();
	         	$carray = explode(" ",trim($msg));
		        $m = $carray[0];
		    	if ($m === "/auctionhouse" or $m === "/ah" or $m === "/shop" or $m === "/pv" or $m === "/playervault") {
                    $player->sendMessage(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Use This Commands In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
	}
	
	/**
     * @param BlockPlaceEvent $event
     */
	public function onPlace(BlockPlaceEvent $event) : void{
		$player = $event->getPlayer();
        if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
                $block = $event->getBlock();
                if ($block->getId() == 7 || $block->getId() == 19 || $block->getId() == 46 || $block->getId() == 52 || $block->getId() == 120 || $block->getId() == 246) {
                    $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Place Block In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
	}

	/**
     * @param PlayerInteractEvent $event
     */
	public function onTouch(PlayerInteractEvent $event) : void{
		$player = $event->getPlayer();
		if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
				$item = $event->getItem();
                if ($item->getId() == 373 || $item->getId() == 339 || $item->getId() == 455 || $item->getId() == 384 || $item->getId() == 368 || $item->getId() == 131 || $item->getId() == 438 || $item->getId() == 259) {
                    $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Use Item In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
        if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
                $block = $event->getBlock();
                if ($block->getId() == 199) {
                    $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Cheating Item Frame In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
    	if ($player->getGamemode() == 1) {
            if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
				$block = $event->getBlock();
                if ($block->getId() == 54 || $block->getId() == 146 || $block->getId() == 130 || $block->getId() == 138 || $block->getId() == 125 || $block->getId() == 23 || $block->getId() == 154 || $block->getId() == 61 || $block->getId() == 379 || $block->getId() == 116 || $block->getId() == 145) {
                    $player->sendTip(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " You Cannot Open In Creative Mode!");
                    $event->setCancelled(true);
				}
			}
		}
	}
	
	/**
     * @param PlayerGameModeChangeEvent $event
     */
	public function onGamemode(PlayerGameModeChangeEvent $event) : void{
		$player = $event->getPlayer();
		if ($player->hasPermission("core.creative.blocked")) {
			# Bypass Use Creative Mode But Have Creative Limited
			if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
			    if ($event->getNewGamemode() == 1) {
                    $player->sendMessage(TextFormat::BOLD . TextFormat::GOLD . "(!)" . TextFormat::RESET . TextFormat::YELLOW . " You Have Been Limited Creative Mode");
                    $player->addTitle(TextFormat::GOLD . "Limited Creative", TextFormat::YELLOW . "You Have Been Limited Creative Mode", 20, 20, 20);
		    	}
		    }
	        if ($player->hasPermission("core.creative.limited")) {
				# No Need Message
			} else {
			    if ($event->getNewGamemode() == 0 || $event->getNewGamemode() == 2 || $event->getNewGamemode() == 3) {
                    $player->sendMessage(TextFormat::BOLD . TextFormat::GOLD . "(!)" . TextFormat::RESET . TextFormat::YELLOW . " You No Longer Limited Creative Mode");
                    $player->addTitle(TextFormat::GOLD . "Limited Creative", TextFormat::YELLOW . "You No Longer Limited Creative Mode", 20, 20, 20);
                    $player->removeAllEffects();
                    $player->getInventory()->clearAll();
                    $player->getArmorInventory()->clearAll();
				}
			}
		} else {
            if ($event->getNewGamemode() == 1 || $event->getNewGamemode() == 2 || $event->getNewGamemode() == 3) {
				$this->plugin->getServer()->getLogger()->notice("Warning " . $player->getName() . " Is Use Cheating Gamemode!");
			    $event->setCancelled(true);
			}
		}
	}
}