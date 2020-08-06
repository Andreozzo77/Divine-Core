<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;

use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use DaPigGuy\PiggyCustomEnchants\CustomEnchantManager;
use pocketmine\utils\TextFormat as TF;

class CeRemoveCommands extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("ceremover.command.ceremove");
        $this->setUsage("/ceremove <enchant>");
        $this->setDescription("Transfer a custom enchant from your item into a book");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
            $cost = 5000;
            if ($sender->getCurrentTotalXp() - $cost < 0) {
                $sender->sendMessage("§c§l(!) §r§cYou don't have enough EXP To use Ceremove");
                $sender->sendMessage("§c§l(!) §r§cYou need §65,000 §cEXP");
            } else {
                if(isset($args[0])){
                    $ench = CustomEnchantManager::getEnchantmentByName($args[0]);
                    if($ench !== null){
                        $item = $sender->getInventory()->getItemInHand();
                        if($item->getEnchantment($ench->getId()) !== null){
                            $lvl = $item->getEnchantment($ench->getId())->getLevel();
                            $ebook = Item::get(403, 0, 1);
                            $ebook->setCustomName(TF::BOLD . TF::BLUE . $args[0] . " " . $lvl . "\nEnchantment Book");	
                            $piggy = $this->owner->getServer()->getPluginManager()->getPlugin("PiggyCustomEnchants");
                            if($piggy instanceof PiggyCustomEnchants) {
                                $ebook->addEnchantment(new EnchantmentInstance(new CustomEnchant($piggy, $ench->getId(), $ench->getRarity()), $lvl));
                                if($sender->getInventory()->canAddItem($ebook)) {
                                    $newItem = clone $item;
                                    $newItem->removeEnchantment($ench->getId());
                                    $inv = $sender->getInventory();
                                    $inv->setItemInHand($newItem);
                                    $inv->addItem($ebook);
									$sender->subtractXp($cost);
                                    $sender->sendMessage(TF::GREEN . "Enchantment " . $args[0] . " was successfully separated into a book from " . $item->getName());
                                }
                                else {
                                    $sender->sendMessage(TF::RED . "You do not have enough space in your inventory to collect the enchantment book");
                                }
                            }
                            else {
                                $sender->sendMessage(TF::LIGHT_PURPLE . "This error was no supposed to occur, contact an Owner as soon as possible");
                            }
                        }
                        else {
                            $sender->sendMessage(TF::RED . "You do not have that enchantment on your currently held item");
                        }
                    }
                    else {
                        $sender->sendMessage(TF::RED . "Such enchantment does not exist");
                    }
                }
                else {
                    $sender->sendMessage("§6Usage: §a/ceremove <enchant>");
                }
            }
			return true;
        }
    }
}