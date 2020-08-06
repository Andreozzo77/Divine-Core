<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class PlayerEvents implements Listener{
	
	/** @var array */
	public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param PlayerLoginEvent $event
     */
	public function onLogin(PlayerLoginEvent $event) {
		$player = $event->getPlayer();
		$ip = $player->getAddress();
		$cid = $player->getClientId();
		// Alias Player IP Address
		$address = new Config($this->plugin->getDataFolder() . "alias/ip/" . $ip . ".txt", Config::ENUM);
		$address->set($player->getName());
		$address->save();
		// Alias Player Client ID
		$client = new Config($this->plugin->getDataFolder() . "alias/cid/" . $cid . ".txt", Config::ENUM);
		$client->set($player->getName());
		$client->save();
		
		// Nickname Joined Keep Forever
		$data = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		if ($player->hasPermission("core.nick.bypass")) {
			if ($data->exists("Nickname", true)) {
		    	$player->setNameTag($data->get("Nickname", true));
		        $player->setDisplayName($data->get("Nickname", true));
			}
		} else {
			// Remove Nickname When Login In Server
	    	if ($data->exists("Nickname", true)) {
		    	$player->setDisplayName($player->getName());
                $player->setNameTag($player->getName());
	            $data->set("Nickname", $player->getName());
	            $data->save();
			}
		}
	}
	
	/**
     * @param PlayerJoinEvent $event
     */
	public function onJoin(PlayerJoinEvent $event) : void{
		$player = $event->getPlayer();
		$data = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		// Username In Minecraft
		if ($data->get("Name") == null) {
			$data->set("Name", $player->getName());
			$data->save();
		}
		// Nickname Player Not Real Name
		if ($data->get("Nickname") == null) {
			$data->set("Nickname", $player->getName());
			$data->save();
		}
		// Kill Points
        if ($data->get("Kill") == null) {
			$data->set("Kill", 0);
			$data->save();
        }
		// Death Points
        if ($data->get("Death") == null) {
			$data->set("Death", 0);
			$data->save();
		}
		// Bounty Money
		if ($data->get("Bounty") == null) {
			$data->set("Bounty", 0);
			$data->save();
        }
	}
}