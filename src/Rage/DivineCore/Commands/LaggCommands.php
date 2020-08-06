<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class LaggCommands extends PluginCommand{
	
	/** @var array */
    protected $exemptedEntities = [];
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Clear the lag");
        $this->setUsage("/lagg <clear|check|killmobs|clearall>");
        $this->setPermission("core.command.lagg");
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.lagg")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return false;
        }
        if (count($args) < 1) {
			$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/lagg <clear|check|mobs|clearall>");
            return false;
        }
		if (isset($args[0])) {
			switch($args[0]) {
				case "clear":
				case "c":
			    $sender->sendMessage("Remove " . $this->removeEntities() . " entities");
				return true;
				case "check":
				case "count":
				$c = $this->getEntityCount();
				$sender->sendMessage("Detected " . $c[0] . " players, " . $c[1] . " mobs, and " . $c[2] . " entities");
				return true;
				case "killmobs":
				case "mobs":
				$sender->sendMessage("Remove " . $this->removeMobs() . " mobs");
				return true;
				case "clearall":
				case "cl":
				case "all":
				$sender->sendMessage("Remove " . ($d = $this->removeMobs()) . " mob" . ($d == 1 ? "" : "s") . " and " . ($d = $this->removeEntities()) . " entit" . ($d == 1 ? "y" : "ies") . "");
				return true;
				default:
				$sender->sendMessage(TextFormat::GOLD . "Usage: " . TextFormat::GREEN . "/lagg <clear|check|mobs|clearall>");
				return false;
			}
		}
		return false;
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