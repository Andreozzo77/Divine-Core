<?php

namespace Rage\DivineCore\Tasks;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\Level;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class RestartTask extends Task{

    /** @var Core */
    public $secs = 0;
	/** @var Core */
    public $plugin;
    
	/**
     * RestartTask constructor.
     * @param Core $plugin
     * @param Player $player
     */
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->console = new ConsoleCommandSender();
    }
    
	/**
     * @param $currentTick
     */
    public function onRun(int $currentTick) : void{
    	$mins = $this->secs / 60;
    	if (!($mins < 1)) {
    		if ($this->secs % 150 === 0) { // 300 = 2.5 Minutes
			    $this->plugin->getServer()->dispatchCommand($this->console, 'mw load Mine');			
    		}
    	}
    	switch($mins) {
    		case 1:
    		$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cServer Restart In §690 §cMinutes");
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw load Mine');
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp true KitPVPOverworld');
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp true FactionSpawn');        
    		break;
    		case 31:
    		$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cServer Restart In §660 §cMinutes");
    	    break;
    		case 61:
    		$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cServer Restart In §630 §cMinutes");
    		break;
    		case 85:
			$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cServer Restart §65 §cMinutes Left, PVP IS NOW DISABLED");
			$this->plugin->getServer()->broadcastTitle(TextFormat::RED . "Warning", TextFormat::GOLD . "Pvp has been disabled", 50, 50, 50);
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp false KitPVPOverworld');
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp false FactionSpawn');
    		break;
    		case 88:
    		$this->plugin->getServer()->broadcastMessage("§l§c(!) §r§cWarning Stop Pvping, the server will restart §62 §cMinutes Left");
			$this->plugin->getServer()->broadcastTitle(TextFormat::RED . "Warning", TextFormat::GOLD . "Stop pvping the server will restart in 5 minutes", 50, 50, 50);
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp true KitPVPOverworld');
            $this->plugin->getServer()->dispatchCommand($this->console, 'mw gamerule pvp true FactionSpawn');
    		case 90:
    		foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
    		    $player->close($player->getLeaveMessage(), TextFormat::YELLOW . "Server Restarted, come back.");
    		}
    		$this->plugin->getServer()->shutdown();
    		break;
    	}
        $this->secs++;
    }
}