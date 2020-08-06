<?php

namespace Rage\DivineCore\Tasks;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class CombatTask extends Task{

    /**
     * CombatTask constructor.
     * @param Core $plugin
     * @param Player $player
     */
    public function __construct($plugin) {
        $this->plugin = $plugin;
	}

    /**
     * @param $currentTick
     */
    public function onRun(int $currentTick) : void{
        foreach($this->plugin->logger as $player => $time) {
            if ((time() - $time) > $this->plugin->loggertime) {
                $p = $this->plugin->getServer()->getPlayer($player);
                if ($p instanceof Player){
                    $p->sendMessage("§a- You are no longer in combat");
                    unset($this->plugin->logger[$player]);
                } else {
			     	unset($this->plugin->logger[$player]);
				}
            }
        }
    }
}