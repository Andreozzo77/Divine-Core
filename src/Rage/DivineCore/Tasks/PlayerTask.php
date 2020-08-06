<?php

namespace Rage\DivineCore\Tasks;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\scheduler\Task;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use onebone\economyapi\EconomyAPI;
use _64FF00\PureChat\PureChat;
use _64FF00\PurePerms\PurePerms;

Class PlayerTask extends Task{

    /** @var int[] */
	public $taggedPlayers = [];
	/** @var array */
	public $player;
	/** @var array */
	public $plugin;
    
    /**
     * TestTask constructor.
     * @param Core $plugin
     * @param Player $player
     */
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param $currentTick
     */
    public function onRun(int $currentTick) : void{
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
			$data = new Config($this->plugin->getDataFolder() . "player/" . strtolower($player->getName()) . ".yml", Config::YAML);
		    $player->setScoreTag("§l§f" . $player->getHealth() . "§cHP§f/" . $player->getMaxHealth() . "§cHP\n§6Bounty: §r§e" . $data->get("Bounty") . "§6$");

		}
	}
}