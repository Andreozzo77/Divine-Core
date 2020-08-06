<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\entity\Zombie;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityEffectAddEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Explosion;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use DaPigGuy\PiggyCustomEnchants\CustomEnchantManager;
use onebone\economyapi\EconomyAPI;
use _64FF00\PurePerms\PPGroup;

class ItemEvents implements Listener{
	
	/** @var array */
	public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
		$this->console = new ConsoleCommandSender();
	}
	
	/**
     * @param PlayerInteractEvent $event
     */
	public function onTouch(PlayerInteractEvent $event) : void{	
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$inv = $player->getInventory();
		$hand = $inv->getItemInHand();
		$nbt = $hand->getNamedTag();	
		if ($hand->getId() == 339 and $hand->getDamage() == 50) {
	    	if ($nbt->getByte("MoneyNote", false) == true) {
		    	if ($nbt->getInt("MoneyVersion", 1.0) == $this->plugin->money) {
			    	$money = $nbt->getInt("Money");
				    EconomyAPI::getInstance()->addMoney($player->getName(), $money);
				    $hand->setCount($hand->getCount() - 1);
				    $inv->setItemInHand($hand);
				    $player->sendTip("§l§a$ " . number_format($money) . "+");
				    $event->setCancelled(true);
				}
			}
		}		
		if ($hand->getId() == 384 and $hand->getDamage() == 50) {
		    if ($nbt->getByte("ExperienceBottle", false) == true) {
		    	if ($nbt->getInt("ExperienceVersion", 1.0) == $this->plugin->experience) {
				    $exp = $nbt->getInt("Experience");
				    $player->addXp($exp);
				    $hand->setCount($hand->getCount() - 1);
				    $inv->setItemInHand($hand);
				    $player->sendTip("§l§aEXP " . number_format($exp) . "+");
				    $event->setCancelled(true);
				}
			}
		}		
		// Custom \nEnchantment Book Tier: 1
		if ($hand->getId() == 340 and $hand->getDamage() == 100 and $hand->getCustomName() == "§r§bCommon Enchantment Book") {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 39);
			switch($reward) {
				case 1:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Telepathy"), 1));
                $item->setCustomName("§r§l§bTelepathy I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically puts drops in inventory',
                '§r§7Tools Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
				$player->sendMessage("§l§b» §r§aYou earn Telepathy Custom Enchantment");
				if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
		    	} else {
                    $player->getInventory()->addItem($item);
				}
				$player->sendMessage("§l§b» §r§aYou earn Telepathy Custom Enchantment");
				break;
				case 2:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Haste"), 1));
                $item->setCustomName("§r§l§bHaste I\nEnchantment Book");
                $item->setLore([
                '§r§eGives effect haste when hold',
                '§r§7Tools Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Haste Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 3:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Haste"), 2));
                $item->setCustomName("§r§l§bHaste II\nEnchantment Book");
                $item->setLore([
                '§r§eGives effect haste when hold',
                '§r§7Tools Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Haste Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 4:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Haste"), 3));
                $item->setCustomName("§r§l§bHaste III\nEnchantment Book");
                $item->setLore([
                '§r§eGives effect haste when hold',
                '§r§7Tools Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Haste Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Springs"), 1));
                $item->setCustomName("§r§l§bSprings I\nEnchantment Book");
                $item->setLore([
                '§r§eGives a jump boost',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Springs Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 6:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Springs"), 2));
                $item->setCustomName("§r§l§bSprings II\nEnchantment Book");
                $item->setLore([
                '§r§eGives a jump boost',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Springs Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 7:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Springs"), 3));
                $item->setCustomName("§r§l§bSprings III\nEnchantment Book");
                $item->setLore([
                '§r§eGives a jump boost',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Springs Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 8:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Gears"), 1));
                $item->setCustomName("§r§l§bGears I\nEnchantment Book");
                $item->setLore([
                '§r§eGives a speed',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Gears Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 9:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Gears"), 2));
                $item->setCustomName("§r§l§bGears II\nEnchantment Book");
                $item->setLore([
                '§r§eGives a speed',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Gears Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 10:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Gears"), 3));
                $item->setCustomName("§r§l§bGears III\nEnchantment Book");
                $item->setLore([
                '§r§eGives a speed',
                '§r§7Boots Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Gears Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 11:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Haste"), 1));
                $item->setCustomName("§r§l§bSmelting I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically smelts drops when block broken',
                '§r§7Tools Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Smelting Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 12:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Glowing"), 1));
                $item->setCustomName("§r§l§bGlowing I\nEnchantment Book");
                $item->setLore([
                '§r§eGives effect night vision',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Glowing Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 13:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lifesteal"), 1));
                $item->setCustomName("§r§l§bLifesteal I\nEnchantment Book");
                $item->setLore([
                '§r§eSteals health upon hitting enemy',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lifesteal Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 14:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lifesteal"), 2));
                $item->setCustomName("§r§l§bLifesteal II\nEnchantment Book");
                $item->setLore([
                '§r§eSteals health upon hitting enemy',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lifesteal Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 15:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lifesteal"), 3));
                $item->setCustomName("§r§l§bLifesteal III\nEnchantment Book");
                $item->setLore([
                '§r§eSteals health upon hitting enemy',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lifesteal Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 16:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lifesteal"), 4));
                $item->setCustomName("§r§l§bLifesteal IV\nEnchantment Book");
                $item->setLore([
                '§r§eSteals health upon hitting enemy',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lifesteal Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 17:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lifesteal"), 5));
                $item->setCustomName("§r§l§bLifesteal V\nEnchantment Book");
                $item->setLore([
                '§r§eSteals health upon hitting enemy',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lifesteal Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 18:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Wither"), 1));
                $item->setCustomName("§r§l§bWither I\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Wither on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wither Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 19:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Wither"), 2));
                $item->setCustomName("§r§l§bWither II\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Wither on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wither Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 20:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Wither"), 3));
                $item->setCustomName("§r§l§bWither III\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Wither on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wither Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 21:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Wither"), 4));
                $item->setCustomName("§r§l§bWither IV\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Wither on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wither Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Wither"), 5));
                $item->setCustomName("§r§l§bWither V\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Wither on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wither Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Poison"), 1));
                $item->setCustomName("§r§l§bPoison I\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Poison on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Poison Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Poison"), 2));
                $item->setCustomName("§r§l§bPoison II\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Poison on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Poison Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Poison"), 3));
                $item->setCustomName("§r§l§bPoison III\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Poison on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Poison Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Poison"), 4));
                $item->setCustomName("§r§l§bPoison IV\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Poison on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Poison Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 27:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Poison"), 5));
                $item->setCustomName("§r§l§bPoison V\nEnchantment Book");
                $item->setLore([
                '§r§eInflict Poison on enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Poison Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 28:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Vampire"), 1));
                $item->setCustomName("§r§l§bVampire I\nEnchantment Book");
                $item->setLore([
                '§r§eConverts damage dealt into health',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Vampire Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 29:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blind"), 1));
                $item->setCustomName("§r§l§bBlind I\nEnchantment Book");
                $item->setLore([
                '§r§eInflict blindness upon hitting enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blindness Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 30:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blind"), 2));
                $item->setCustomName("§r§l§bBlind II\nEnchantment Book");
                $item->setLore([
                '§r§eInflict blindness upon hitting enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blindness Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 31:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blind"), 3));
                $item->setCustomName("§r§l§bBlind III\nEnchantment Book");
                $item->setLore([
                '§r§eInflict blindness upon hitting enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blindness Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 32:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blind"), 4));
                $item->setCustomName("§r§l§bBlind IV\nEnchantment Book");
                $item->setLore([
                '§r§eInflict blindness upon hitting enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blindness Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 33:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blind"), 5));
                $item->setCustomName("§r§l§bBlind V\nEnchantment Book");
                $item->setLore([
                '§r§eInflict blindness upon hitting enemies',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blindness Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 34:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Vitamins"), 1));
                $item->setCustomName("§r§l§bVitamins I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants immunity to hunger',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Vitamins Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 35:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Obsidianshield"), 1));
                $item->setCustomName("§r§l§bObsidian Shield I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants fire resistance',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Vitamins Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 36:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Aegis"), 1));
                $item->setCustomName("§r§l§bAegis I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants resistance',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Aegis Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 37:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Angel"), 1));
                $item->setCustomName("§r§l§bAngel I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants regeneration',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Angel Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 38:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Angel"), 2));
                $item->setCustomName("§r§l§bAngel II\nEnchantment Book");
                $item->setLore([
                '§r§eGrants regeneration',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Angel Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 39:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Angel"), 3));
                $item->setCustomName("§r§l§bAngel III\nEnchantment Book");
                $item->setLore([
                '§r§eGrants regeneration',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Angel Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;					
			}
		}
		// Custom \nEnchantment Book Tier: 2
		if ($hand->getId() == 340 and $hand->getDamage() == 101 and $hand->getCustomName() == "§r§eUncommon Enchantment Book") {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 30);
			switch($reward) {
				case 1:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Rage"), 1));
                $item->setCustomName("§r§l§eRage I\nEnchantment Book");
                $item->setLore([
                '§r§eGains Strength when hold.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Rage Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 2:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Rage"), 2));
                $item->setCustomName("§r§l§eRage II\nEnchantment Book");
                $item->setLore([
                '§r§eGains Strength when hold.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Rage Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 3:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Rage"), 3));
                $item->setCustomName("§r§l§eRage III\nEnchantment Book");
                $item->setLore([
                '§r§eGains Strength when hold.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Rage Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 4:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Rage"), 4));
                $item->setCustomName("§r§l§eRage IV\nEnchantment Book");
                $item->setLore([
                '§r§eGains Strength when hold.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Rage Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Rage"), 5));
                $item->setCustomName("§r§l§eRage V\nEnchantment Book");
                $item->setLore([
                '§r§eGains Strength when hold.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Rage Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 6:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Autorepair"), 1));
                $item->setCustomName("§r§l§eAutorepair I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically repairs items',
                '§r§7Global Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Autorepair Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 7:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Fertilizer"), 1));
                $item->setCustomName("§r§l§eFertilizer I\nEnchantment Book");
                $item->setLore([
                '§r§eCreates farmland in a level radius around the block',
                '§r§7Hoe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Fertilizer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 8:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lumberjack"), 1));
                $item->setCustomName("§r§l§eLumberjack I\nEnchantment Book");
                $item->setLore([
                '§r§eMines all logs connected to log when broken',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lumberjack Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 9:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Antitoxin"), 1));
                $item->setCustomName("§r§l§eAntitoxin I\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to poison',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Antitoxin Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 10:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Focused"), 1));
                $item->setCustomName("§r§l§eFocused I\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Focused Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 11:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Focused"), 2));
                $item->setCustomName("§r§l§eFocused II\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Focused Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 12:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Focused"), 3));
                $item->setCustomName("§r§l§eFocused III\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Focused Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 13:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Focused"), 4));
                $item->setCustomName("§r§l§eFocused IV\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Focused Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 14:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Focused"), 5));
                $item->setCustomName("§r§l§eFocused V\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Helmets Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Focused Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 15:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blessed"), 1));
                $item->setCustomName("§r§l§eBlessed I\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blessed Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 16:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blessed"), 2));
                $item->setCustomName("§r§l§eBlessed II\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blessed Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 17:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Blessed"), 3));
                $item->setCustomName("§r§l§eBlessed III\nEnchantment Book");
                $item->setLore([
                '§r§e20% (1 = level) chance Immunity to Nausea',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blessed Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 18:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Farmer"), 1));
                $item->setCustomName("§r§l§eFarmer I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically replace seeds when crop is broken',
                '§r§7Hoe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Farmer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 19:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Nourish"), 1));
                $item->setCustomName("§r§l§eNourish I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants immunty to wither',
                '§r§7Helmet Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Nourish Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 20:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Quickening"), 1));
                $item->setCustomName("§r§l§eQuickening I\nEnchantment Book");
                $item->setLore([
                '§r§eGain speed upon breaking block',
                '§r§7Pickaxe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Quickening Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 21:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Revive"), 1));
                $item->setCustomName("§r§l§eRevive I\nEnchantment Book");
                $item->setLore([
                '§r§eGain another life',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Quickening Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Volley"), 1));
                $item->setCustomName("§r§l§eVolley I\nEnchantment Book");
                $item->setLore([
                '§r§eShoots multiple arrows in a cone shape',
                '§r§7Bow Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Volley Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 1));
                $item->setCustomName("§r§l§eVoodoo I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 2));
                $item->setCustomName("§r§l§eVoodoo II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 3));
                $item->setCustomName("§r§l§eVoodoo III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 4));
                $item->setCustomName("§r§l§eVoodoo IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 27:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 5));
                $item->setCustomName("§r§l§eVoodoo V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 28:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 6));
                $item->setCustomName("§r§l§eVoodoo VI\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 29:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 7));
                $item->setCustomName("§r§l§eVoodoo VII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 30:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("VooDoo"), 8));
                $item->setCustomName("§r§l§eVoodoo VIII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict enemies with wither effect',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Voodoo Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;					
			}
		}
		// Custom \nEnchantment Book Tier: 3
		if ($hand->getId() == 340 and $hand->getDamage() == 102 and $hand->getCustomName() == "§r§6Rare Enchantment Book") {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 33);
			switch($reward) {
				case 1:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 1));
                $item->setCustomName("§r§l§6Deathbringer I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease sword damage',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 2:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 2));
                $item->setCustomName("§r§l§6Deathbringer II\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease sword damage',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 3:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 3));
                $item->setCustomName("§r§l§6Deathbringer III\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease sword damage',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 4:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 4));
                $item->setCustomName("§r§l§6Deathbringer IV\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease sword damage',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 5));
                $item->setCustomName("§r§l§6Deathbringer V\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease sword damage',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 6:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 1));
                $item->setCustomName("§r§l§6Overload I\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 7:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 2));
                $item->setCustomName("§r§l§6Overload II\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 8:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 3));
                $item->setCustomName("§r§l§6Overload III\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 9:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 4));
                $item->setCustomName("§r§l§6Overload IV\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 10:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 5));
                $item->setCustomName("§r§l§6Overload V\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 11:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 5));
                $item->setCustomName("§r§l§6Overload V\nEnchantment Book");
                $item->setLore([
                '§r§eGives 1 extra heart per level per armor piece',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 12:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Tank"), 1));
                $item->setCustomName("§r§l§6Tank I\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from axe by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Tank Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 13:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Tank"), 2));
                $item->setCustomName("§r§l§6Tank II\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from axe by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Tank Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 14:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Tank"), 3));
                $item->setCustomName("§r§l§6Tank III\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from axe by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Tank Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 15:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Armored"), 1));
                $item->setCustomName("§r§l§6Armored I\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from sword by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Armored Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 16:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Armored"), 2));
                $item->setCustomName("§r§l§6Armored II\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from sword by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Armored Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 17:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Armored"), 3));
                $item->setCustomName("§r§l§6Armored III\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from sword by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Armored Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 18:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Heavy"), 1));
                $item->setCustomName("§r§l§6Heavy I\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from bow by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Heavy Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 19:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Heavy"), 2));
                $item->setCustomName("§r§l§6Heavy II\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from bow by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Heavy Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 20:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Heavy"), 3));
                $item->setCustomName("§r§l§6Heavy III\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases damage from bow by 10%',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Heavy Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 21:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("WovensHack"), 1));
                $item->setCustomName("§r§l§6Wovens Hack I\nEnchantment Book");
                $item->setLore([
                '§r§eAuto sells items from your inventory when mining',
                '§r§7Tool Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Wovens Hack Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 1));
                $item->setCustomName("§r§l§6Insanity I\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break; 
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 2));
                $item->setCustomName("§r§l§6Insanity II\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;   
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 3));
                $item->setCustomName("§r§l§6Insanity III\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;         
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 4));
                $item->setCustomName("§r§l§6Insanity IV\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;    
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 5));
                $item->setCustomName("§r§l§6Insanity V\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;     
				case 27:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 6));
                $item->setCustomName("§r§l§6Insanity VI\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;     
				case 28:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deflect"), 1));
                $item->setCustomName("§r§l§6Deflect I\nEnchantment Book");
                $item->setLore([
                '§r§eReflect enemies attack damage',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deflect Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  	
				case 29:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deflect"), 2));
                $item->setCustomName("§r§l§6Deflect II\nEnchantment Book");
                $item->setLore([
                '§r§eReflect enemies attack damage',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deflect Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  
				case 30:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deflect"), 3));
                $item->setCustomName("§r§l§6Deflect III\nEnchantment Book");
                $item->setLore([
                '§r§eReflect enemies attack damage',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deflect Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 31:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deflect"), 4));
                $item->setCustomName("§r§l§6Deflect IV\nEnchantment Book");
                $item->setLore([
                '§r§eReflect enemies attack damage',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deflect Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break; 
				case 32:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deflect"), 5));
                $item->setCustomName("§r§l§6Deflect V\nEnchantment Book");
                $item->setLore([
                '§r§eReflect enemies attack damage',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deflect Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;     				
				case 33:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Painkiller"), 1));
                $item->setCustomName("§r§l§6Painkiller I\nEnchantment Book");
                $item->setLore([
                '§r§eAquired high level of resistance when low on healtj',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Painkiller Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  
				case 34:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Painkiller"), 2));
                $item->setCustomName("§r§l§6Painkiller II\nEnchantment Book");
                $item->setLore([
                '§r§eAquired high level of resistance when low on healtj',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Painkiller Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break; 
				case 35:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Painkiller"), 3));
                $item->setCustomName("§r§l§6Painkiller I\nEnchantment Book");
                $item->setLore([
                '§r§eAquired high level of resistance when low on healtj',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Painkiller Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;   	
				case 33:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Painkiller"), 1));
                $item->setCustomName("§r§l§6Painkiller I\nEnchantment Book");
                $item->setLore([
                '§r§eAquired high level of resistance when low on healtj',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Painkiller Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  				
			}				
		}
		if ($hand->getId() == 340 and $hand->getDamage() == 103 and $hand->getCustomName() == "§r§cMythic Enchantment Book") {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 31);
			switch($reward) {
				case 1:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 1));
                $item->setCustomName("§r§l§cInflux I\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 2:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 2));
                $item->setCustomName("§r§l§cInflux II\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 3:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 3));
                $item->setCustomName("§r§l§cInflux III\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 4:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 1));
                $item->setCustomName("§r§l§cShatterglass I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 2));
                $item->setCustomName("§r§l§cShatterglass II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 3));
                $item->setCustomName("§r§l§cShatterglass III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 6:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 4));
                $item->setCustomName("§r§l§cShatterglass IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 7:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 5));
                $item->setCustomName("§r§l§cShatterglass V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 8:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 1));
                $item->setCustomName("§r§l§cBloodlost I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 9:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 2));
                $item->setCustomName("§r§l§cBloodlost II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 10:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 3));
                $item->setCustomName("§r§l§cBloodlost III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 11:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 4));
                $item->setCustomName("§r§l§cBloodlost IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 12:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 1));
                $item->setCustomName("§r§l§cKnight I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 13:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 2));
                $item->setCustomName("§r§l§cKnight II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 14:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 3));
                $item->setCustomName("§r§l§cKnight III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 15:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 4));
                $item->setCustomName("§r§l§cKnight IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 16:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 5));
                $item->setCustomName("§r§l§cKnight V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 17:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 6));
                $item->setCustomName("§r§l§cKnight VI\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 18:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 7));
                $item->setCustomName("§r§l§cKnight VII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 19:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 8));
                $item->setCustomName("§r§l§cKnight VIII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 20:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Autoaim"), 1));
                $item->setCustomName("§r§l§cAuto Aim I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically aims to the nearest target.',
                '§r§7Bow Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 21:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Clarity"), 1));
                $item->setCustomName("§r§l§cClarity I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants Immunity to poison',
                '§r§7Helmet Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Clarity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("I'mFastAFBoi"), 1));
                $item->setCustomName("§r§l§cI'm Fast AF Boi I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants immunity to slowness',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn I'm Fast AF Boi Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 1));
                $item->setCustomName("§r§l§cBlood Berserk I\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 2));
                $item->setCustomName("§r§l§cBlood Berserk II\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 3));
                $item->setCustomName("§r§l§cBlood Berserk III\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 4));
                $item->setCustomName("§r§l§cBlood Berserk IV\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 27:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 5));
                $item->setCustomName("§r§l§cBlood Berserk V\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 28:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 6));
                $item->setCustomName("§r§l§cBlood Berserk VI\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 29:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Dodge"), 1));
                $item->setCustomName("§r§l§cDodge I\nEnchantment Book");
                $item->setLore([
                '§r§eDodges enemies attack',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Dodge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 30:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Dodge"), 2));
                $item->setCustomName("§r§l§cDodge II\nEnchantment Book");
                $item->setLore([
                '§r§eDodges enemies attack',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Dodge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 31:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Dodge"), 3));
                $item->setCustomName("§r§l§cDodge III\nEnchantment Book");
                $item->setLore([
                '§r§eDodges enemies attack',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Dodge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;					
			}
		}			
		if ($hand->getId() == 340 and $hand->getDamage() == 104 and $hand->getCustomName() == "§r§3§lSpecial§b Enchantment Book") {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 47);
			switch($reward) {
				case 1:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 1));
                $item->setCustomName("§r§l§cInflux I\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 2:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 4));
                $item->setCustomName("§r§l§cInflux IV\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 3:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Influx"), 5));
                $item->setCustomName("§r§l§cInflux V\nEnchantment Book");
                $item->setLore([
                '§r§eChane to inflicts enemies massive poison, wither',
				'§r§e(Chance to ignore Antitoxin, Nourish enchants)',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Influx Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 4:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 4));
                $item->setCustomName("§r§l§cShatterglass IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 5:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 4));
                $item->setCustomName("§r§l§cShatterglass IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 6:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 5));
                $item->setCustomName("§r§l§cShatterglass V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 7:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 4));
                $item->setCustomName("§r§l§cShatterglass IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 8:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Shatterglass"), 5));
                $item->setCustomName("§r§l§cShatterglass V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to weaken enemies amor durability',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Shatterglass Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 9:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 1));
                $item->setCustomName("§r§l§cBloodlost I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 10:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 4));
                $item->setCustomName("§r§l§cBloodlost IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 11:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Bloodlost"), 5));
                $item->setCustomName("§r§l§cBloodlost V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to inflict massive damage upon hitting enemies.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Bloodlost Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 12:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 1));
                $item->setCustomName("§r§l§cKnight I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 13:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 2));
                $item->setCustomName("§r§l§cKnight II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 14:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 3));
                $item->setCustomName("§r§l§cKnight III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 15:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 4));
                $item->setCustomName("§r§l§cKnight IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 16:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 5));
                $item->setCustomName("§r§l§cKnight V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 17:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 6));
                $item->setCustomName("§r§l§cKnight VI\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 18:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 10));
                $item->setCustomName("§r§l§cKnight X\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 19:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Knight"), 9));
                $item->setCustomName("§r§l§cKnight IX\nEnchantment Book");
                $item->setLore([
                '§r§eChance to gain Invincible for 5 seconds',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 20:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Autoaim"), 1));
                $item->setCustomName("§r§l§cAuto Aim I\nEnchantment Book");
                $item->setLore([
                '§r§eAutomatically aims to the nearest target.',
                '§r§7Bow Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Knight Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 21:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Clarity"), 1));
                $item->setCustomName("§r§l§cClarity I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants Immunity to poison',
                '§r§7Helmet Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Clarity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("I'mFastAFBoi"), 1));
                $item->setCustomName("§r§l§cI'm Fast AF Boi I\nEnchantment Book");
                $item->setLore([
                '§r§eGrants immunity to slowness',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn I'm Fast AF Boi Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 1));
                $item->setCustomName("§r§l§cBlood Berserk I\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 2));
                $item->setCustomName("§r§l§cBlood Berserk II\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 3));
                $item->setCustomName("§r§l§cBlood Berserk III\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 4));
                $item->setCustomName("§r§l§cBlood Berserk IV\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 27:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 5));
                $item->setCustomName("§r§l§cBlood Berserk V\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 28:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("BloodBerserk"), 6));
                $item->setCustomName("§r§l§cBlood Berserk VI\nEnchantment Book");
                $item->setLore([
                '§r§eDecreases Bloodlost Enchantment Damage per lvl',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Blood Berserk Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 29:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 1));
                $item->setCustomName("§r§l§cReforge I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 30:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 2));
                $item->setCustomName("§r§l§cReforge II\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 31:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 3));
                $item->setCustomName("§r§l§cReforge III\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 32:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 4));
                $item->setCustomName("§r§l§cReforge IV\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 33:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 5));
                $item->setCustomName("§r§l§cReforge V\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 34:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 6));
                $item->setCustomName("§r§l§cReforge VI\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 35:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 7));
                $item->setCustomName("§r§l§cReforge VII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 36:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 8));
                $item->setCustomName("§r§l§cReforge VIII\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 37:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 9));
                $item->setCustomName("§r§l§cReforge IX\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 38:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Reforge"), 10));
                $item->setCustomName("§r§l§cReforge X\nEnchantment Book");
                $item->setLore([
                '§r§eChance to add more Enchanted golden apple cooldown for 1 second, per lvl = 1 second',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Reforge Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;				
				case 39:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Enlighted"), 1));
                $item->setCustomName("§r§l§eEnlighted I\nEnchantment Book");
                $item->setLore([
                '§r§eGain Regeneration when hit.',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 40:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Enlighted"), 2));
                $item->setCustomName("§r§l§eEnlighted II\nEnchantment Book");
                $item->setLore([
                '§r§eGain Regeneration when hit.',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 41:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Enlighted"), 3));
                $item->setCustomName("§r§l§eEnlighted III\nEnchantment Book");
                $item->setLore([
                '§r§eGain Regeneration when hit.',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 42:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 5));
                $item->setCustomName("§r§l§6Overload V\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;			
				case 43:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 6));
                $item->setCustomName("§r§l§6Overload VI\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Overload Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 44:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 7));
                $item->setCustomName("§r§l§6Overload VII\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 45:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 8));
                $item->setCustomName("§r§l§6Overload VIII\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 46:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 9));
                $item->setCustomName("§r§l§6Overload IX\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 47:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Overload"), 10));
                $item->setCustomName("§r§l§6Overload X\nEnchantment Book");
                $item->setLore([
                '§r§eGives extra health (stackable).',
                '§r§7Armor Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Enlighted Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 48:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 5));
                $item->setCustomName("§r§l§6Deathbringer V\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 49:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 6));
                $item->setCustomName("§r§l§6Deathbringer VI\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;
				case 50:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 7));
                $item->setCustomName("§r§l§6Deathbringer VII\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 51:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 8));
                $item->setCustomName("§r§l§6Deathbringer VIII\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 52:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 9));
                $item->setCustomName("§r§l§6Deathbringer IX\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;					
				case 53:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathbringer"), 10));
                $item->setCustomName("§r§l§6Deathbringer VII\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases damage inflicted.',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathbringer Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 54:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathforged"), 1));
                $item->setCustomName("§r§l§cDeathforged I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease massive damage and give high level of strength when held',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathforged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 55:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathforged"), 2));
                $item->setCustomName("§r§l§cDeathforged I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease massive damage and give high level of strength when held',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathforged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 56:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathforged"), 3));
                $item->setCustomName("§r§l§cDeathforged I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease massive damage and give high level of strength when held',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathforged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 57:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathforged"), 4));
                $item->setCustomName("§r§l§cDeathforged I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease massive damage and give high level of strength when held',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathforged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;		
				case 58:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Deathforged"), 5));
                $item->setCustomName("§r§l§cDeathforged I\nEnchantment Book");
                $item->setLore([
                '§r§eIncrease massive damage and give high level of strength when held',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Deathforged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;					
			}
		}	
		if ($hand->getId() == 339 and $hand->getDamage() == 2) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 27);
			switch($reward) {
				case 1:
				$player->sendMessage("§l§b» §r§aYou earned 50 XP");
				$player->addXp("50");
				break;
				case 2:
				$player->sendMessage("§l§b» §r§aYou earned 61 XP");
				$player->addXp("61");
				break;
				case 3:
				$player->sendMessage("§l§b» §r§aYou earned 68 XP");
				$player->addXp("68");
				break;
				case 4:
				$player->sendMessage("§l§b» §r§aYou earned 69 XP");
				$player->addXp("69");
				break;
				case 5:
				$player->sendMessage("§l§b» §r§aYou earned 71 XP");
				$player->addXp("71");
				break;
				case 6:
				$player->sendMessage("§l§b» §r§aYou earned 78 XP");
				$player->addXp("78");
				break;
				case 7:
				$player->sendMessage("§l§b» §r§aYou earned 82 XP");
				$player->addXp("82");
				break;
				case 8:
				$player->sendMessage("§l§b» §r§aYou earned 73 XP");
				$player->addXp("73");
				break;
				case 9:
				$player->sendMessage("§l§b» §r§aYou earned 89 XP");
				$player->addXp("89");
				break;
				case 10:
				$player->sendMessage("§l§b» §r§aYou earned 76 XP");
				$player->addXp("76");
				break;
				case 11:
				$player->sendMessage("§l§b» §r§aYou earned 128 XP");
				$player->addXp("128");
				break;
				case 12:
				$player->sendMessage("§l§b» §r§aYou earned 908 XP");
				$player->addXp("908");
				break;
				case 13:
				$player->sendMessage("§l§b» §r§aYou earned 451 XP");
				$player->addXp("451");
				break;
				case 14:
				$player->sendMessage("§l§b» §r§aYou earned 651 XP");
				$player->addXp("651");
				break;
				case 15:
				$player->sendMessage("§l§b» §r§aYou earned 713 XP");
				$player->addXp("713");
				break;
				case 16:
				$player->sendMessage("§l§b» §r§aYou earned 816 XP");
				$player->addXp("816");
				break;
				case 17:
				$player->sendMessage("§l§b» §r§aYou earned 291 XP");
				$player->addXp("291");
				break;
				case 18:
				$player->sendMessage("§l§b» §r§aYou earned 371 XP");
				$player->addXp("371");
				break;
				case 19:
				$player->sendMessage("§l§b» §r§aYou earned 918 XP");
				$player->addXp("918");
				break;		
				case 20:
				$player->sendMessage("§l§b» §r§aYou earned 456 XP");
				$player->addXp("456");
				break;		
				case 21:
				$player->sendMessage("§l§b» §r§aYou earned 412 XP");
				$player->addXp("412");
				break;	
				case 22:
				$player->sendMessage("§l§b» §r§aYou earned 219 XP");
				$player->addXp("219");
				break;
				case 23:
				$player->sendMessage("§l§b» §r§aYou earned 55 XP");
				$player->addXp("55");
				break;	
				case 24:
				$player->sendMessage("§l§b» §r§aYou earned 59 XP");
				$player->addXp("59");
				break;	
				case 25:
				$player->sendMessage("§l§b» §r§aYou earned 59 XP");
				$player->addXp("59");
				break;	
				case 26:
				$player->sendMessage("§l§b» §r§aYou earned 101 XP");
				$player->addXp("101");
				break;	
				case 27:
				$player->sendMessage("§l§b» §r§aYou earned 69 XP");
				$player->addXp("69");
				break;	
				case 28:
				$player->sendMessage("§l§b» §r§aYou earned 69 XP");
				$player->addXp("68");
				break;		
				case 29:
				$player->sendMessage("§l§b» §r§aYou earned 69 XP");
				$player->addXp("69");
				break;
				case 30:
				$player->sendMessage("§l§b» §r§aYou earned 69 XP");
				$player->addXp("108");
				break;		
				case 31:
				$player->sendMessage("§l§b» §r§aYou earned 56 XP");
				$player->addXp("56");
				break;	
				case 32:
				$player->sendMessage("§l§b» §r§aYou earned 231 XP");
				$player->addXp("69");
				break;	
				case 33:
				$player->sendMessage("§l§b» §r§aYou earned 211 XP");
				$player->addXp("211");
				break;		
				case 34:
				$player->sendMessage("§l§b» §r§aYou earned 208 XP");
				$player->addXp("208");
				break;	
				case 35:
				$player->sendMessage("§l§b» §r§aYou earned 213 XP");
				$player->addXp("35");
				break;	
				case 36:
				$player->sendMessage("§l§b» §r§aYou earned 53 XP");
				$player->addXp("53");
				break;	
				case 37:
				$player->sendMessage("§l§b» §r§aYou earned 325 XP");
				$player->addXp("325");
				break;	
				case 38:
				$player->sendMessage("§l§b» §r§aYou earned 39 XP");
				$player->addXp("105");
				break;	
			}				
		}		
		if ($hand->getId() == 384 and $hand->getDamage() == 105) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 38);
			switch($reward) {
				case 1:
				$player->sendMessage("§l§b» §r§aYou earned 1000 XP");
				$player->addXp("1000");
				break;
				case 2:
				$player->sendMessage("§l§b» §r§aYou earned 2000 XP");
				$player->addXp("2000");
				break;
				case 3:
				$player->sendMessage("§l§b» §r§aYou earned 3000 XP");
				$player->addXp("3000");
				break;
				case 4:
				$player->sendMessage("§l§b» §r§aYou earned 4500 XP");
				$player->addXp("4500");
				break;
				case 5:
				$player->sendMessage("§l§b» §r§aYou earned 5600 XP");
				$player->addXp("5600");
				break;
				case 6:
				$player->sendMessage("§l§b» §r§aYou earned 8250 XP");
				$player->addXp("8250");
				break;
				case 7:
				$player->sendMessage("§l§b» §r§aYou earned 9851 XP");
				$player->addXp("9851");
				break;
				case 8:
				$player->sendMessage("§l§b» §r§aYou earned 1250 XP");
				$player->addXp("1250");
				break;
				case 9:
				$player->sendMessage("§l§b» §r§aYou earned 1005 XP");
				$player->addXp("1005");
				break;
				case 10:
				$player->sendMessage("§l§b» §r§aYou earned 2590 XP");
				$player->addXp("2590");
				break;
				case 11:
				$player->sendMessage("§l§b» §r§aYou earned 10,000 XP");
				$player->addXp("10000");
				break;
				case 12:
				$player->sendMessage("§l§b» §r§aYou earned 12,000 XP");
				$player->addXp("12000");
				break;
				case 13:
				$player->sendMessage("§l§b» §r§aYou earned 5600 XP");
				$player->addXp("5600");
				break;
				case 14:
				$player->sendMessage("§l§b» §r§aYou earned 2501 XP");
				$player->addXp("2501");
				break;
				case 15:
				$player->sendMessage("§l§b» §r§aYou earned 1599 XP");
				$player->addXp("1599");
				break;
				case 16:
				$player->sendMessage("§l§b» §r§aYou earned 12900 XP");
				$player->addXp("12900");
				break;
				case 17:
				$player->sendMessage("§l§b» §r§aYou earned 51000 XP");
				$player->addXp("51000");
				break;
				case 18:
				$player->sendMessage("§l§b» §r§aYou earned 5000 XP");
				$player->addXp("5000");
				break;
				case 19:
				$player->sendMessage("§l§b» §r§aYou earned 95000 XP");
				$player->addXp("95000");
				break;		
				case 20:
				$player->sendMessage("§l§b» §r§aYou earned 12000 XP");
				$player->addXp("12000");
				break;		
				case 21:
				$player->sendMessage("§l§b» §r§aYou earned 15000 XP");
				$player->addXp("15000");
				break;	
				case 22:
				$player->sendMessage("§l§b» §r§aYou earned 75000 XP");
				$player->addXp("75000");
				break;
				case 23:
				$player->sendMessage("§l§b» §r§aYou earned 1003 XP");
				$player->addXp("1003");
				break;	
				case 24:
				$player->sendMessage("§l§b» §r§aYou earned 1001 XP");
				$player->addXp("1001");
				break;	
				case 25:
				$player->sendMessage("§l§b» §r§aYou earned 1002 XP");
				$player->addXp("1002");
				break;	
				case 26:
				$player->sendMessage("§l§b» §r§aYou earned 1002 XP");
				$player->addXp("1002");
				break;	
				case 27:
				$player->sendMessage("§l§b» §r§aYou earned 16969 XP");
				$player->addXp("16969");
				break;	
				case 28:
				$player->sendMessage("§l§b» §r§aYou earned 16969 XP");
				$player->addXp("16969");
				break;		
				case 29:
				$player->sendMessage("§l§b» §r§aYou earned 16969 XP");
				$player->addXp("16969");
				break;
				case 30:
				$player->sendMessage("§l§b» §r§aYou earned 16969 XP");
				$player->addXp("16969");
				break;		
				case 31:
				$player->sendMessage("§l§b» §r§aYou earned 1000 XP");
				$player->addXp("1000");
				break;	
				case 32:
				$player->sendMessage("§l§b» §r§aYou earned 6969 XP");
				$player->addXp("6969");
				break;	
				case 33:
				$player->sendMessage("§l§b» §r§aYou earned 6969 XP");
				$player->addXp("6969");
				break;		
				case 34:
				$player->sendMessage("§l§b» §r§aYou earned 6969 XP");
				$player->addXp("6969");
				break;	
				case 35:
				$player->sendMessage("§l§b» §r§aYou earned 1269 XP");
				$player->addXp("1269");
				break;	
				case 36:
				$player->sendMessage("§l§b» §r§aYou earned 1269 XP");
				$player->addXp("1269");
				break;	
				case 37:
				$player->sendMessage("§l§b» §r§aYou earned 1325 XP");
				$player->addXp("1325");
				break;	
				case 38:
				$player->sendMessage("§l§b» §r§aYou earned 1025 XP");
				$player->addXp("1025");
			    break;	
			}
		}
		if ($hand->getId() == 465 and $hand->getDamage() == 1) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 4);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh cow 1 ' . $player->getName());		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh pig 1 ' . $player->getName());	
				$player->addXp("61");
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh Chicken 1 ' . $player->getName());	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh Chicken 1 ' . $player->getName());	
				break;
			}
		}	
		if ($hand->getId() == 465 and $hand->getDamage() == 2) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 4);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh spider 1 ' . $player->getName());		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh skeleton 1 ' . $player->getName());	
				$player->addXp("61");
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh enderman 1 ' . $player->getName());	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh spider 1 ' . $player->getName());	
				break;
			}
		}		
		if ($hand->getId() == 465 and $hand->getDamage() == 3) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 4);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh blaze 1 ' . $player->getName());		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh irongolem 1 ' . $player->getName());	
				$player->addXp("61");
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh vindicator 1 ' . $player->getName());	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'nh blaze 1 ' . $player->getName());	
				break;
			}
		}
		if ($hand->getId() == 339 and $hand->getDamage() == 150) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 20);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1000');		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 2000');		
				$player->addXp("61");
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 3000');	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 4000');	
				break;	
				case 5:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 5000');	
				break;	
				case 6:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 6000');	
				break;	
				case 7:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 7000');	
				break;	
				case 8:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 8000');	
				break;	
				case 9:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 9000');	
				break;	
				case 10:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 10000');	
				break;	
				case 11:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1920');	
				break;					
				case 12:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1005');	
				break;				
				case 13:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1200');	
				break;					
				case 14:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 2250');	
				break;		
				case 15:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 3010');	
				break;	
				case 16:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 2020');	
				break;		
				case 17:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 6969');	
				break;	
				case 18:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 9500');	
				break;	
				case 19:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 3005');	
				break;		
				case 20:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 4000');	
				break;						
			}
		}
		if ($hand->getId() == 120 and $hand->getDamage() == 1) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 21);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 19 32');		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 19 64');		
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' diamond_block 16');	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' diamond_block 32');	
				break;	
				case 5:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Rare 1 ' . $player->getName());	
				break;	
				case 6:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Legendary 1 ' . $player->getName());
				break;	
				case 7:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Common 1 ' . $player->getName());	
				break;	
				case 8:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Common 1 ' . $player->getName());	
				break;	
				case 9:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Common 1 ' . $player->getName());
				break;	
				case 10:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' diamond_block 16');	
				break;	
				case 11:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 50000');	
				break;					
				case 12:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 60000');	
				break;				
				case 13:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 70000');	
				break;					
				case 14:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 80000');	
				break;		
				case 15:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 224:1 1');	
				break;	
				case 16:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 224:1 1');	
				break;		
				case 17:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 10000 ' . $player->getName());	
				break;	
				case 18:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 20000 ' . $player->getName());	
				break;	
				case 19:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 30000 ' . $player->getName());		
				break;		
				case 20:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 40000 ' . $player->getName());	
				break;	
				case 21:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 50000 ' . $player->getName());	
				break;					
			}
		}		
		if ($hand->getId() == 120 and $hand->getDamage() == 2) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 26);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'b ' . $player->getName() . ' zombie 1');		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'b ' . $player->getName() . ' zombie 1');		
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 466 1');	
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 466 2');	
				break;	
				case 5:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Rare 16 ' . $player->getName());	
				break;	
				case 6:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Rare 32 ' . $player->getName());
				break;	
				case 7:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Legendary 6 ' . $player->getName());	
				break;	
				case 8:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Legendary 6 ' . $player->getName());	
				break;	
				case 9:
				$this->plugin->getServer()->dispatchCommand($this->console, 'key Rare 16 ' . $player->getName());
				break;	
				case 10:
				$this->plugin->getServer()->dispatchCommand($this->console, 'b ' . $player->getName() . ' zombie 1');	
				break;	
				case 11:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1000000');	
				break;					
				case 12:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 1500000');	
				break;				
				case 13:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 2000000');	
				break;					
				case 14:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 2500000');	
				break;		
				case 15:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 224:1 1');	
				break;	
				case 16:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 224:1 1');	
				break;		
				case 17:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 100000 ' . $player->getName());	
				break;	
				case 18:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 150000 ' . $player->getName());	
				break;	
				case 19:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 200000 ' . $player->getName());		
				break;		
				case 20:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 150000 ' . $player->getName());	
				break;	
				case 21:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 100000 ' . $player->getName());	
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Lightning"), 1));
                $item->setCustomName("§r§l§cLightning I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to strike enemies with lightning',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Lightning Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	     
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Hallucination"), 1));
                $item->setCustomName("§r§l§cHallucination I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to trap enemies in prison',
                '§r§7Sword Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Hallucination Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	
				case 22:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Silence"), 1));
                $item->setCustomName("§r§l§6Silence I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to remove enemies regeneration',
                '§r§7Weapon Enchant',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Silence Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	   
				case 23:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Spitsweb"), 1));
                $item->setCustomName("§r§l§cSpits Web I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to trap enemies with cobwebs. Cooldown: 60 Seconds',
                '§r§eCooldown: 60 Seconds',
                '§r§7Weapon Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Spits Web Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;	  
				case 24:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 7));
                $item->setCustomName("§r§l§6Insanity VII\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;     
				case 25:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Insanity"), 8));
                $item->setCustomName("§r§l§6Insanity VIII\nEnchantment Book");
                $item->setLore([
                '§r§eIncreases massive damage in Axes',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Insanity Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  
				case 26:
				$item = Item::get(403, 0, 1);
			    $item->addEnchantment(new EnchantmentInstance(CustomEnchantManager::getEnchantmentByName("Razoredged"), 1));
                $item->setCustomName("§r§l§cRazoredged I\nEnchantment Book");
                $item->setLore([
                '§r§eChance to ignore enemies armor and deals damage when activated',
                '§r§7Axe Enchantment',
                '§r§7Combine it into item to enchant'
                ]);
                $player->sendMessage("§l§b» §r§aYou earn Razoredged Custom Enchantment");
                if (!$player->getInventory()->canAddItem($item)) {
				    $player->dropItem($item);
			    } else {
                    $player->getInventory()->addItem($item);
				}
				break;  
			}
		}	
		if ($hand->getId() == 120 and $hand->getDamage() == 3) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 21);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 378:5 1');		
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lInfusion Material 1x");
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 378:5 1');		
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lInfusion Material 1x");
				break;
				case 3:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 219 64');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lDiamond Mining Generator 64x");
				break;
				case 4:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 219 128');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lDiamond Mining Generator 128x");
				break;	
				case 5:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 234 128');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lDiamond Auto Generator 128x");
				break;	
				case 6:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 219 64');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lDiamond Auto Generator 64x");
				break;	
				case 7:
				$this->plugin->getServer()->dispatchCommand($this->console, 'setgroup ' . $player->getName() . ' Divine');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lDivine Rank");
				break;	
				case 8:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 467:13 1');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lCorona Gkit");
				break;	
				case 9:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 10000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l10,000,000,000$");
				break;	
				case 10:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 9000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l9,000,000,000$");
				break;	
				case 11:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 5000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l5,000,000,000$");
				break;					
				case 12:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 6000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l6,000,000,000$");
				break;				
				case 13:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 7000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l7,000,000,000$");
				break;					
				case 14:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 8000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l8,000,000,000$");
				break;		
				case 15:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givemoney ' . $player->getName() . ' 8000000000');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l8,000,000,000$");
				break;	
				case 16:
				$this->plugin->getServer()->dispatchCommand($this->console, 'give ' . $player->getName() . ' 224:1 128x');	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§lLegendary Lucky Blocks 128x");
				break;		
				case 17:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 10000000 ' . $player->getName());	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l10,000,000 EXP");
				break;	
				case 18:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 20000000 ' . $player->getName());	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l20,000,000 EXP");
				break;	
				case 19:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 30000000 ' . $player->getName());	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l30,000,000 EXP");
				break;		
				case 20:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 40000000 ' . $player->getName());	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l40,000,000 EXP");
				break;	
				case 21:
				$this->plugin->getServer()->dispatchCommand($this->console, 'givexp 50000000 ' . $player->getName());	
				$this->plugin->getServer()->broadcastMessage("§a§l(!) §r§e" . $player->getName() . " §aopened a §cAce of Joker Crate§r§a and got §6§l50,000,000 EXP");
				break;	
			}
		}	
		if ($hand->getId() == 389 and $hand->getDamage() == 0) {
			$hand->setCount($hand->getCount() - 1);
			$inv->setItemInHand($hand);
			$event->setCancelled(true);
			$reward = rand(1, 2);
			switch($reward) {
				case 1:
				$this->plugin->getServer()->dispatchCommand($this->console, 'sm ' . $player->getName() . ' §c§l(!) §r§cThis item is banned, you cannot place this item');		
				break;
				case 2:
				$this->plugin->getServer()->dispatchCommand($this->console, 'sm ' . $player->getName() . ' §c§l(!) §r§cThis item is banned, you cannot place this item');		
				break;
            }
        }    
	}
}