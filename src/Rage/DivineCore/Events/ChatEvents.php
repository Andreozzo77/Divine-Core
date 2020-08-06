<?php

namespace Rage\DivineCore\Events;

use Rage\DivineCore\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
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
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class ChatEvents implements Listener{

	/** @var array */
	public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
	}
	
	/**
     * @param PlayerChatEvent $event
     */
	public function onChat(PlayerChatEvent $event) : void{
	    $player = $event->getPlayer();
		$message = $event->getMessage();
		// Staff Chat Private Only
        if (isset($this->plugin->staffchat[$player->getLowerCaseName()])) {
			foreach($this->plugin->getServer()->getOnlinePlayers() as $target) {
                if ($target->hasPermission("core.command.staff")) {
					$target->sendMessage(TextFormat::YELLOW . "§8[§6SC§8] " . TextFormat::GOLD . $player->getName() . ": " . TextFormat::GREEN . $message);
				    $event->setCancelled(true);
				}
			}
		}
		// Lowercase Message no Caps in Chat
		$strlen = strlen($message);
        $asciiA = ord("A");
        $asciiZ = ord("Z");
        $count = 0;
        for($i = 0; $i < $strlen; $i++) {
            $char = $message[$i];
            $ascii = ord($char);
            if ($asciiA <= $ascii and $ascii <= $asciiZ) {
                $count++;
            }
        }
        if ($player->hasPermission("core.anticaps.bypass")) {
			# No Need When Permission Players
		} else {
            $event->setMessage(strtolower($message));
		}
	}
	
	/**
     * @param PlayerCommandPreprocessEvent $event
     */
    public function onCommand(PlayerCommandPreprocessEvent $event): void{
		$player = $event->getPlayer();
		$name = $player->getName();
		$message = $event->getMessage();
		// Permission Colour Chat
        $command = $this->colorMessage($message, $player);
        if (empty($command)) {
            $event->setCancelled();
        }
        $event->setMessage((string) $command);
    }
	
	/**
     * @param PlayerQuitEvent $event
     */
	public function onQuit(PlayerQuitEvent $event) : void{
		$player = $event->getPlayer();
		if (isset($this->plugin->staffchat[$player->getLowerCaseName()])) {
			unset($this->plugin->staffchat[$player->getLowerCaseName()]);
		}
	}
	
	/**
     * Return a colored message replacing every
     * color code (&a = §a)
     * @param string $message
     * @param Player|null $player
     * @param bool $force
     * @return null|string
     */
    public function colorMessage(string $message, Player $player = null, bool $force = false): ?string{
        $message = preg_replace_callback(
            "/(\\\&|\&)[0-9a-fk-or]/",
            function(array $matches) {
                return str_replace("\\§", "&", str_replace("&", "§", $matches[0]));
            },
            $message
        );
        if (strpos($message, "§") !== false && ($player instanceof Player) && !$player->hasPermission("core.colorchat.bypass") && !$force) {
            $player->sendMessage(TextFormat::RED . "You don't have permissions to use color chat");
            return null;
        }
        return $message;
    }
}