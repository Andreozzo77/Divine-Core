<?php

namespace Rage\DivineCore\Commands;

use Rage\DivineCore\Main;
use DaPigGuy\PiggyCustomEnchants\CustomEnchantManager;
use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat as TF;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;

class CeRemoveAllCommands extends PluginCommand
{

    private const PLAYER_SLOTS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35];

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("ceremover.command.ceremoveall");
        $this->setUsage("/ceremoveall");
        $this->setDescription("Transfer all custom enchants from your item into enchanted books");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
            $inv = $sender->getInventory();
            $count = 0;
            foreach (self::PLAYER_SLOTS as $slot){
                if($inv->getItem($slot)->getId() == Item::AIR){
                    $count++;
                }
            }
            $item = $inv->getItemInHand();
            $enchs = $item->getEnchantments();
            $cenchs = [];
            foreach ($enchs as $ench){
                if($ench->getId() > 32 or $ench->getId() < 0){
                    array_push($cenchs, $ench);
                }
            }
            if(count($cenchs) <= $count){
                $newItem = clone $item;
                foreach ($cenchs as $cench){
                    $newItem->removeEnchantment($cench->getId());
                    $ebook = Item::get(Item::ENCHANTED_BOOK);
                    $piggy = $this->owner->getServer()->getPluginManager()->getPlugin("PiggyCustomEnchants");
                    $newCench = CustomEnchantManager::getEnchantment($cench->getId());
                    if($piggy instanceof PiggyCustomEnchants) {
                        $ebook->addEnchantment(new EnchantmentInstance(new CustomEnchant($piggy, $newCench->getId(), $newCench->getRarity(), $lvl)));
                        $inv->addItem($ebook);
                    }
                }
                //$inv->removeItem($item);
                //$inv->addItem($newItem);
                $inv->setItemInHand($newItem);
                $sender->sendMessage(TF::GREEN . "All the custom enchantments were successfully separated into enchantment books from " . $item->getName());
            }
            else {
                $sender->sendMessage(TF::RED . "You do not have enough space in your inventory to collect all the enchantment books");
            }
        }
    }
}