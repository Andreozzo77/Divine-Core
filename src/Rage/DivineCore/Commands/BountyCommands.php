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

use onebone\economyapi\EconomyAPI;

class BountyCommands extends PluginCommand{
	
	/** @var array */
	public $bountycd;
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Bounty Commands");
        $this->setUsage("/bounty <add|remove|me|see>");
        $this->setPermission("core.command.bounty");
		$this->economy = EconomyAPI::getInstance();
		$this->plugin = $plugin;
    }

	/**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("core.command.bounty")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty <add|remove|me|see> <player>");
            return false;
        }
		if (isset($args[0])) {
		    switch(strtolower($args[0])) {
				case "me":
				if (!$sender->hasPermission("core.command.bounty.me")) {
					$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
					return false;
				} 
				$bounty = new Config($this->plugin->getDataFolder() . "player/" . strtolower($sender->getName()) . ".yml", Config::YAML);
				$money = $bounty->get("Bounty");
                if ($money !== 0) {
					$sender->sendMessage(TextFormat::GREEN . "Your Current Bounty Money: " . TextFormat::AQUA . "$" . $money);
				} else {
					$sender->sendMessage(TextFormat::GOLD . "You do not have a bounty on you");
				}
				return true;
				case "see":
				if (!$sender->hasPermission("core.command.bounty.see")) {
					$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
					return false;
				} 
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty see <player>");
                    return false;
				}
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
				if ($target == true) {
			    	$bounty = new Config($this->plugin->getDataFolder() . "player/" . strtolower($target->getName()). ".yml", Config::YAML);
			    	$money = $bounty->get("Bounty");
                    if ($money !== 0) {
				    	$sender->sendMessage(TextFormat::GREEN . $target->getName() . " Is Have Bounty Money: " . TextFormat::YELLOW . "$" . $money);
			    	} else {
				    	$sender->sendMessage(TextFormat::RED . $target->getName() . " Is do not have any bounty");
			    	}
				}
				return true;
				case "add":
				case "new":
				if (!$sender->hasPermission("core.command.bounty.add")) {
					$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
					return false;
				} 
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty add <player> <amount>");
                    return false;
				}
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
				if (count($args) < 3) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty add <player> <amount>");
                    return false;
				}
				if (!isset($this->plugin->bountycd[$sender->getLowerCaseName()]) || time() > $this->plugin->bountycd[$sender->getLowerCaseName()] || $sender->hasPermission("core.cooldown.bypass")) {
				    if (is_numeric($args[2])) {
                        $amount = (int)$args[2];
		                $bal = EconomyAPI::getInstance()->myMoney($sender);
			            if ($bal >= $amount) {
					        // Bounty Add
					        if ($amount >= 1000 && $amount <= 1000000000) {
			                 	$bounty = new Config($this->plugin->getDataFolder() . "player/" . strtolower($target->getName()) . ".yml", Config::YAML);
					            EconomyAPI::getInstance()->reduceMoney($sender, $amount);
				                $currentamount = $bounty->get("Bounty");
                                if ($currentamount !== null) {
                                    $bounty->set("Bounty", ($currentamount + $amount));
                                } else {
                                    $bounty->set("Bounty", $amount);
				                }
                                $bounty->save();
							    $this->plugin->bountycd[$sender->getLowerCaseName()] = time() + 300;
						        foreach($sender->getServer()->getOnlinePlayers() as $player) {
						    	    $player->sendMessage(TextFormat::BOLD . TextFormat::YELLOW . "(!) " . TextFormat::RESET . TextFormat::GOLD . $target->getName() . TextFormat::YELLOW . " Has a Bounty Worth " . TextFormat::GOLD . "$" . number_format($amount) . TextFormat::YELLOW . " Kill Them To Get Reward!");
						        }
					        } else {
						        $sender->sendMessage(TextFormat::RED . "Please provide a number 1,000 - 1,000,000,000");
				                return false;
					        }
				    	} else {
			                $sender->sendMessage(TextFormat::RED . "You don't have enough money to bounty" . TextFormat::GOLD . " Cost: $" . number_format($amount));
					        return false;
			     	    }
			    	} else {
			            $sender->sendMessage(TextFormat::RED . "Please specify a valid number");
			            return false;
					}
				} else {
					$sender->sendMessage(TextFormat::BOLD . TextFormat::RED . "(!)" . TextFormat::RESET . TextFormat::RED . " Bounty Command Is Cooldown!");
				}
				return true;
				case "remove":
				case "delete":
				if (!$sender->hasPermission("core.command.bounty.remove")) {
					$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
					return false;
				} 
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty remove <player>");
                    return false;
				}
				$target = $this->getPlayer($args[1]);
			    if ($target == null) {
                    $sender->sendMessage(TextFormat::RED . "That player cannot be found");
                    return false;
				}
				if ($target == true) {
			    	$bounty = new Config($this->plugin->getDataFolder() . "player/" . strtolower($target->getName()) . ".yml", Config::YAML);
					$bounty->set("Bounty", 0);
			        $bounty->save();
					Command::broadcastCommandMessage($sender, "Successfully Reset " . $target->getName() . " Bounty To 0");
				}
				return true;
				default:
				$sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /bounty <add|remove|me|see> <player>");
			    return false;
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