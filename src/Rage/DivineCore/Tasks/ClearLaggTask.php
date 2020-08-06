<?php

namespace Rage\DivineCore\Tasks;

use Rage\DivineCore\Main;

use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\scheduler\Task;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

/**
 * Class ClearLaggTask
 * @package CoreSkyblock\Tasks
 */
class ClearLaggTask extends Task{

    /** @var Core */
	private $plugin;

	/**
     * ClearLaggTask constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

	/**
     * @param $currentTick
     */
    public function onRun(int $currentTick) : void{
		//$this->plugin->getLogger()->info("Remove " . ($d = $this->removeMobs()) . " mob" . ($d == 1 ? "" : "s") . " and " . ($d = $this->removeEntities()) . " entit" . ($d == 1 ? "y" : "ies") . "");
		$this->plugin->getLogger()->info("Remove " . ($d = $this->removeEntities()) . " entit" . ($d == 1 ? "y" : "ies") . "");
    }

	/**
	 * @return int
	 */
	public function removeEntities(): int {
        $i = 0;
        foreach($this->plugin->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if (!$this->isEntityExempted($entity) && !($entity instanceof Creature)) {
                    $entity->close();
                    $i++;
				}
			}
		}
        return $i;
	}

	/**
	 * @return int
	 */
    public function removeMobs(): int {
        $i = 0;
        foreach($this->plugin->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if (!$this->isEntityExempted($entity) && $entity instanceof Creature && !($entity instanceof Human)) {
                    $entity->close();
                    $i++;
				}
			}
		}
        return $i;
	}

	/**
	 * @return array
	 */
    public function getEntityCount(): array {
        $ret = [0, 0, 0];
        foreach($this->plugin->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if ($entity instanceof Human) {
                    $ret[0]++;
                } else {
                    if ($entity instanceof Creature) {
                        $ret[1]++;
                    } else {
                        $ret[2]++;
					}
				}
			}
		}
        return $ret;
	}

	/**
	 * @param Entity $entity
	 */
    public function exemptEntity(Entity $entity): void {
        $this->plugin->exemptedEntities[$entity->getID()] = $entity;
	}

	/**
	 * @param Entity $entity
	 *
	 * @return bool
	 */
    public function isEntityExempted(Entity $entity): bool {
        return isset($this->plugin->exemptedEntities[$entity->getID()]);
	}
}