<?php

namespace Rage\DivineCore;

use  Rage\DivineCore\Commands\Warp\SetSpawnCommands;
use  Rage\DivineCore\Commands\Warp\SpawnCommands;
use Rage\DivineCore\Commands\Warp\WarpCommands;

use Rage\DivineCore\Commands\AliasCommands;
use Rage\DivineCore\Commands\BountyCommands;
use Rage\DivineCore\Commands\BragCommands;
use Rage\DivineCore\Commands\CeShopCommands;
use Rage\DivineCore\Commands\CeListCommands;
use Rage\DivineCore\Commands\CeRemoveCommands;
use Rage\DivineCore\Commands\CeRemoveAllCommands;
use Rage\DivineCore\Commands\ClearCommands;
use Rage\DivineCore\Commands\FeedCommands;
use Rage\DivineCore\Commands\FlyCommands;
use Rage\DivineCore\Commands\StoreCommands;
use Rage\DivineCore\Commands\YtCommands;
use Rage\DivineCore\Commands\GamemodeCommands;
use Rage\DivineCore\Commands\GivekeyCommands;
use Rage\DivineCore\Commands\GivexpCommands;
use Rage\DivineCore\Commands\GuideCommands;
use Rage\DivineCore\Commands\HealCommands;
use Rage\DivineCore\Commands\LaggCommands;
use Rage\DivineCore\Commands\LinksCommands;
use Rage\DivineCore\Commands\NicknameCommands;
use Rage\DivineCore\Commands\RankCommands;
use Rage\DivineCore\Commands\WarzoneCommands;
use Rage\DivineCore\Commands\RealNameCommands;
use Rage\DivineCore\Commands\RepairCommands;
use Rage\DivineCore\Commands\RulesCommands;
use Rage\DivineCore\Commands\SetTagCommands;
use Rage\DivineCore\Commands\SeeCommands;
use Rage\DivineCore\Commands\SpawnerCommands;
use Rage\DivineCore\Commands\StaffCommands;
use Rage\DivineCore\Commands\StatsCommands;
use Rage\DivineCore\Commands\SuicideCommands;
use Rage\DivineCore\Commands\HealthCommands;
use Rage\DivineCore\Commands\TagCommands;
use Rage\DivineCore\Commands\TellCommands;
use Rage\DivineCore\Commands\VersionCommands;
use Rage\DivineCore\Commands\WithdrawCommands;
use Rage\DivineCore\Commands\SeeHpCommands;
use Rage\DivineCore\Commands\OnceCommands;
use Rage\DivineCore\Commands\SpawnerShopCommands;
use Rage\DivineCore\Commands\NCommands;
use Rage\DivineCore\Commands\PremCommands;
use Rage\DivineCore\Commands\GeneratorCommands;
use Rage\DivineCore\Commands\BossCommands;
use Rage\DivineCore\Commands\SoulCommands;
use Rage\DivineCore\Commands\EnvoyCommands;
use Rage\DivineCore\Commands\JokerCommands;
use Rage\DivineCore\Commands\XpCommands;
use Rage\DivineCore\Commands\DupeCommands;

use Rage\DivineCore\Tasks\ClearLaggTask;
use Rage\DivineCore\Tasks\RestartTask;

use Rage\DivineCore\Events\ChatEvents;
use Rage\DivineCore\Events\CreativeEvents;
use Rage\DivineCore\Events\EntityEvents;
use Rage\DivineCore\Events\ItemEvents;
use Rage\DivineCore\Events\PlayerEvents;
use Rage\DivineCore\Events\ProtectionEvents;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\entity\Entity;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Tile;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use DaPigGuy\PiggyCustomEnchants\CustomEnchantManager;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI;
use _64FF00\PureChat\PureChat;
use _64FF00\PurePerms\PurePerms;

class Main extends PluginBase{
    
	const MAIN_PREFIX = "§cTest";
	
	/** @var array */
	public $experience = 2.0;
	public $money = 2.0;
	
	/** @var array */
	public $loggertime = 10;
	
	/** @var array */
	public $logger = array();    
    
	public function onLoad() : void{
	    
		// CustomEnchants Plugin
		$ce = $this->getServer()->getPluginManager()->getPlugin("PiggyCustomEnchants");
		if ($ce instanceof PiggyCustomEnchants) {
			$this->getServer()->getLogger()->notice("Load PureChat CustomEnchants!");
		} else {
			$this->getServer()->getLogger()->warning("Error no Plugin CustomEnchants!");
		}		
		// EconomyAPI Plugin
		$economyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		if ($economyAPI instanceof EconomyAPI) {
			$this->getServer()->getLogger()->notice("Load PureChat EconomyAPI!");
		} else {
			$this->getServer()->getLogger()->warning("Error no Plugin EconomyAPI!");
		}
		// FormAPI Plugin
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if ($api instanceof FormAPI) {
			$this->getServer()->getLogger()->notice("Load FormAPI successful!");
		} else {
			$this->getServer()->getLogger()->warning("Error no Plugin FormAPI!");
		}
		// PurePerms Plugin
		$purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
		if ($purePerms instanceof PurePerms) {
			$this->getServer()->getLogger()->notice("Load PureChat PurePerms!");
		} else {
			$this->getServer()->getLogger()->warning("Error no Plugin PurePerms!");
		}
		// PureChat Plugin
		$pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
		if ($pureChat instanceof PureChat) {
			$this->getServer()->getLogger()->notice("Load PureChat successful!");
		} else {
			$this->getServer()->getLogger()->warning("Error no Plugin PureChat!");
		}
	}    
	
	/** @var array */
	public function onEnable(): void{
		# Folder File
		$this->saveDefaultConfig();
		if (!is_dir($this->getDataFolder())) {
            mkdir($this->getDataFolder());
        }
		if (!is_dir($this->getDataFolder() . "alias")) {
            mkdir($this->getDataFolder() . "alias");
        }
		if (!is_dir($this->getDataFolder() . "alias/cid")) {
            mkdir($this->getDataFolder() . "alias/cid");
        }
		if (!is_dir($this->getDataFolder() . "alias/ip")) {
            mkdir($this->getDataFolder() . "alias/ip");
        }
		if (!is_dir($this->getDataFolder() . "cooldown")) {
            mkdir($this->getDataFolder() . "cooldown");
		}
		if (!is_dir($this->getDataFolder() . "player")) {
            mkdir($this->getDataFolder() . "player");
        }
		# Commands
		$this->getServer()->getCommandMap()->register("alias", new AliasCommands("alias", $this));
		$this->getServer()->getCommandMap()->register("bounty", new BountyCommands("bounty", $this));	
		$this->getServer()->getCommandMap()->register("brag", new BragCommands("brag", $this));
		$this->getServer()->getCommandMap()->register("celist", new CeListCommands("celist", $this));		
		$this->getServer()->getCommandMap()->register("ceremove", new CeRemoveCommands("ceremove", $this));				
		$this->getServer()->getCommandMap()->register("ceremoveall", new CeRemoveAllCommands("ceremoveall", $this));	
		$this->getServer()->getCommandMap()->register("ceshop", new CeShopCommands("ceshop", $this));		
		$this->getServer()->getCommandMap()->register("clear", new ClearCommands("clear", $this));
		$this->getServer()->getCommandMap()->register("feed", new FeedCommands("feed", $this));
		$this->getServer()->getCommandMap()->register("fly", new FlyCommands("fly", $this));
		$this->getServer()->getCommandMap()->register("gamemode", new GamemodeCommands("gamemode", $this));
		$this->getServer()->getCommandMap()->register("givekey", new GivekeyCommands("givekey", $this));
		$this->getServer()->getCommandMap()->register("givexp", new GivexpCommands("givexp", $this));
		$this->getServer()->getCommandMap()->register("guide", new GuideCommands("guide", $this));
		$this->getServer()->getCommandMap()->register("heal", new HealCommands("heal", $this));
		$this->getServer()->getCommandMap()->register("myhp", new HealthCommands("myhp", $this));
		$this->getServer()->getCommandMap()->register("lagg", new LaggCommands("lagg", $this));
		$this->getServer()->getCommandMap()->register("yt", new YtCommands("yt", $this));
		$this->getServer()->getCommandMap()->register("links", new LinksCommands("links", $this));
		$this->getServer()->getCommandMap()->register("nickname", new NicknameCommands("nickname", $this));
		$this->getServer()->getCommandMap()->register("rank", new RankCommands("rank", $this));
		$this->getServer()->getCommandMap()->register("store", new StoreCommands("store", $this));
		$this->getServer()->getCommandMap()->register("realname", new RealNameCommands("realname", $this));
		$this->getServer()->getCommandMap()->register("repair", new RepairCommands("repair", $this));
		$this->getServer()->getCommandMap()->register("rules", new RulesCommands("rules", $this));
		$this->getServer()->getCommandMap()->register("setspawn", new SetSpawnCommands("setspawn", $this));		
		$this->getServer()->getCommandMap()->register("settag", new SetTagCommands("settag", $this));
		$this->getServer()->getCommandMap()->register("staff", new StaffCommands("staff", $this));
		$this->getServer()->getCommandMap()->register("stats", new StatsCommands("stats", $this));
		$this->getServer()->getCommandMap()->register("spawn", new SpawnCommands("spawn", $this));		
		$this->getServer()->getCommandMap()->register("suicide", new SuicideCommands("suicide", $this));
		$this->getServer()->getCommandMap()->register("seeexp", new SeeCommands("seeexp", $this));
		$this->getServer()->getCommandMap()->register("seehp", new SeeHpCommands("seehp", $this));
		$this->getServer()->getCommandMap()->register("tag", new TagCommands("tag", $this));
		$this->getServer()->getCommandMap()->register("tell", new TellCommands("tell", $this));
		$this->getServer()->getCommandMap()->register("version", new VersionCommands("version", $this));
		$this->getServer()->getCommandMap()->register("warp", new WarpCommands("warp", $this));		
		$this->getServer()->getCommandMap()->register("warzone", new WarzoneCommands("warzone", $this));
		$this->getServer()->getCommandMap()->register("withdraw", new WithdrawCommands("withdraw", $this));
		$this->getServer()->getCommandMap()->register("once", new OnceCommands("once", $this));
		$this->getServer()->getCommandMap()->register("spawner", new SpawnerShopCommands("spawner", $this));
		$this->getServer()->getCommandMap()->register("nightvision", new NCommands("nightvision", $this));
		$this->getServer()->getCommandMap()->register("premium", new PremCommands("premium", $this));
		$this->getServer()->getCommandMap()->register("generator", new GeneratorCommands("generator", $this));
		$this->getServer()->getCommandMap()->register("boss", new BossCommands("boss", $this));
		$this->getServer()->getCommandMap()->register("soulc", new SoulCommands("soulc", $this));
		$this->getServer()->getCommandMap()->register("env", new EnvoyCommands("env", $this));
		$this->getServer()->getCommandMap()->register("jker", new JokerCommands("jker", $this));
		$this->getServer()->getCommandMap()->register("xpshop", new XpCommands("xpshop", $this));
		$this->getServer()->getCommandMap()->register("dupe", new DupeCommands("dupe", $this));
		
		#events
		$this->getServer()->getPluginManager()->registerEvents(new ChatEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new CreativeEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new EntityEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new ItemEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlayerEvents($this), $this);
		
		# Tasks
		$this->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this), 1200*20);
		$this->getScheduler()->scheduleRepeatingTask(new RestartTask($this), 20);
		
    }
	public function loadWorld() : void{
	    $this->getServer()->loadLevel("KitPVPOverworld");	
	    $this->getServer()->loadLevel("Mine");		
	}		
	public function unregisterCommand() : void{
        $map = $this->getServer()->getCommandMap();
        foreach(["version", "tell", "gamemode"] as $command) {
            $map->unregister($map->getCommand($command));
        }
    }
}