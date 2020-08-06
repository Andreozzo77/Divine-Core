<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class CombatEvents implements Listener{
	
	/** @var array */
	public $logger;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param EntityDamageEvent $event
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
	public function onDamage(EntityDamageEvent $event) : void{
		if ($event instanceof EntityDamageByEntityEvent) {
            if ($event->getDamager() instanceof Player and $event->getEntity() instanceof Player) {
                foreach(array($event->getDamager(),$event->getEntity()) as $players) {
					if ($players->hasPermission("c.bypass")) {
						# No Need Message
					} else {
                        $this->CombatLog($players);
					}
                }
            }
        }
	}

	/**
     * @param PlayerQuitEvent $event
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
	public function onQuit(PlayerQuitEvent $event) : void{
		$player = $event->getPlayer();
		if (isset($this->plugin->logger[$player->getLowerCaseName()])) {
            $player->kill();
		    unset($this->plugin->logger[$player->getLowerCaseName()]);
        }
	}
	
	/**
     * @param PlayerCommandPreprocessEvent $event
     */
	public function onPlayerCommand(PlayerCommandPreprocessEvent $event) : void{
		$player = $event->getPlayer();
        if (isset($this->plugin->logger[$player->getLowerCaseName()])) {
			$msg = $event->getMessage();
	     	$carray = explode(" ",trim($msg));
		    $m = $carray[0];
			if ($m === "/feed" or $m === "/heal" or $m === "/f" or $m === "/wz" or $m === "/koth" or $m === "/warzone" or $m === "/fly" or $m === "/hub" or $m === "/wild" or $m === "/nickname" or $m === "/nick" or $m === "/sethome" or $m === "/home" or $m === "/spawn" or $m === "/playervault" or $m === "/pv" or $m === "/warp" or $m === "/warps" or $m === "/tpa" or $m === "/tpahere" or $m === "/tpaccept" or $m === "/top") {
				$player->sendMessage("§cYou cannot execute this command while in combat!");
				$player->addTitle("§c§lError");
				$player->addSubTitle("§6You cannot use commands while Combat tagged");
				$event->setCancelled(true);
			}
        }
	}

	/**
     * @param PlayerDeathEvent $event
     */
	public function onDeath(PlayerDeathEvent $event) : void{
		$entity = $event->getEntity();
		// Combat logger
		if (isset($this->plugin->logger[$entity->getLowerCaseName()])) {
            unset($this->plugin->logger[$entity->getLowerCaseName()]);
        }
	}
	
	/**
	 * @param CombatLog
	 * @param Player $player
     */
	public function CombatLog(Player $player) : void{
        $msg = "§c§l(!)§r§c You are now in combat, do not logout or you will be punished! \n§c§l(!) §r§cPlease wait §6" . $this->plugin->loggertime . " §cseconds";
        if (isset($this->plugin->logger[$player->getLowerCaseName()])) {
            if ((time() - $this->plugin->logger[$player->getLowerCaseName()]) > $this->plugin->loggertime) {
				$player->setAllowFlight(false);
			    $player->setFlying(false);
                $player->sendMessage($msg);  
				$player->addTitle("§c§lCombat Tag");
				$player->addSubTitle("§6You are now in combat tag");				
            }
        } else {
			$player->setAllowFlight(false);
			$player->setFlying(false);
            $player->sendMessage($msg);
        }
        $this->plugin->logger[$player->getLowerCaseName()] = time();
    }
}