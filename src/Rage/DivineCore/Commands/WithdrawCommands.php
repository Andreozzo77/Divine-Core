<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

use onebone\economyapi\EconomyAPI;

class WithdrawCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;
	/** @var array */
    public $economy;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Withdraw to money or experience");
        $this->setUsage("/withdraw <money|experience> <amount>");
        $this->setAliases(["wt"]);
        $this->setPermission("core.command.withdraw");
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
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
            return false;
        }
        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /withdraw <money|experience> <amount>");
            return false;
        }
		if (isset($args[0])) {
		    switch(strtolower($args[0])) {
				case "economy":
				case "money":
				// Withdraw Money
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /withdraw money <amount>");
                    return false;
				}
				if (is_numeric($args[1])) {
                    $amount = (int)$args[1];
		            $bal = EconomyAPI::getInstance()->myMoney($sender);
		         	if ($bal >= $amount) {
			            if ($amount >= 100 && $amount <= 10000000) {
				          	EconomyAPI::getInstance()->reduceMoney($sender, $amount);
				          	$note = Item::get(339, 50, 1);
					        $note->setCustomName("§r§l§eBank Note");
					        $note->setLore([
					        '§r§dValue §f$' . number_format($amount),
			     	        '§r§6Tap note to get Money reward'
		                   	]);
					        $nbt = $note->getNamedTag();
							$nbt->setTag(new ByteTag("MoneyNote", true));
				            $nbt->setTag(new IntTag("MoneyVersion", $this->plugin->money));
					        $nbt->setTag(new IntTag("Money", $amount));
					        $note->setCompoundTag($nbt);
					        $sender->getInventory()->addItem($note);
					        $sender->sendMessage(TextFormat::GREEN . "You successful withdraw Money Note " . TextFormat::YELLOW . "$" . number_format($amount));
				        } else {
				        	$sender->sendMessage(TextFormat::RED . "Please provide a number 100 - 10,000,000");
						}
		          	} else {
			        	$sender->sendMessage(TextFormat::RED . "You don't have enough money to withdraw" . TextFormat::GOLD . " Cost: $" . number_format($amount));
					}
	         	} else {
		          	$sender->sendMessage(TextFormat::RED . "Please specify a valid number");
				}
				return true;
				case "experience":
				case "exp":
				// Withdraw Experience
				if (count($args) < 2) {
                    $sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /withdraw exp <amount>");
                    return false;
				}
				if (is_numeric($args[1])) {
                    $amount = (int)$args[1];
		         	if ($amount >= 100 && $amount <= 10000000) {
		               	if ($sender->getCurrentTotalXp() - $amount < 0) {
			             	$sender->sendMessage(TextFormat::RED . "You don't have enough experience to Withdraw" . TextFormat::GOLD . " EXP: " . number_format($amount));
		             	} else {
				        	$sender->subtractXp($amount);
				            $exp = Item::get(384, 50, 1);
				            $exp->setCustomName("§r§l§aExperience Bottle");
				            $exp->setLore([
				            '§r§dValue §f' . number_format($amount),
                            '§r§6Tap bottle to get Experience reward'
                            ]);
				            $nbt = $exp->getNamedTag();
				            $nbt->setTag(new ByteTag("ExperienceBottle", true));
				            $nbt->setTag(new IntTag("ExperienceVersion", $this->plugin->experience));
					        $nbt->setTag(new IntTag("Experience", $amount));
				            $exp->setCompoundTag($nbt);
				            $sender->getInventory()->addItem($exp);
				            $sender->sendMessage(TextFormat::GREEN . "You successful withdraw Experience Bottle " . TextFormat::YELLOW . "EXP: " . number_format($amount));
				        }
			        } else {
			        	$sender->sendMessage(TextFormat::RED . "Please provide a number 100 - 10,000,000");
			        }
		        } else {
			        $sender->sendMessage(TextFormat::RED . "Please specify a valid number");
				}
				return true;
			    default:
				$sender->sendMessage(TextFormat::GOLD . "Usage:" . TextFormat::GREEN . " /withdraw <money|exp> <amount>");
			    return false;
			}
		}
	}
}
