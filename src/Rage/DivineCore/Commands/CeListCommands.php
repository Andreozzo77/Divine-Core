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

class CeListCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("List of ce");
        $this->setUsage("/celist");
		$this->setAliases(["cl", "ce", "ceinfo"]);
        $this->setPermission("core.list");
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
			$form->addLabel(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->RuleUI($sender);
		return true;
	}

	/**
	 * @param RuleUI
	 * @param Player $player
     */
	public function RuleUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function (Player $player, $data) {
           $result = $data[0];
	    });
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§b§lCustom Enchants");
		$form->addLabel("§l§aAdrenaline");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGives high level of speeds when activated");
		$form->addLabel("§r§a");
		$form->addLabel("§l§aDeflect");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to deflect enemies damage");
		$form->addLabel("§r§a");	
		$form->addLabel("§l§aPainkiller");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eAquires high level of resisatance when low on health");
		$form->addLabel("§r§a");	
		$form->addLabel("§l§aDodge");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e8");
		$form->addLabel("§r§aDescription: §eChance to evade enemies attack");
		$form->addLabel("§r§a");	
		$form->addLabel("§l§aVoodoo");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e8");
		$form->addLabel("§r§aDescription: §eChance to inflict enemies weakness");
		$form->addLabel("§r§a");	
		$form->addLabel("§l§aHealing Factor");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e8");
		$form->addLabel("§r§aDescription: §eGains High level of regeneration when low on health");
		$form->addLabel("§r§a");		
		$form->addLabel("§l§aAegis");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGives resistance when equipped");
		$form->addLabel("§r§a");
		$form->addLabel("§l§aAngel");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e3");
		$form->addLabel("§r§aDescription: §eGives regeneration when equipped");		
		$form->addLabel("§r§a");
		$form->addLabel("§l§aArmored");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eSword-inflicted damage is reduced.");		
        $form->addLabel("§r§a");		
		$form->addLabel("§l§aBerserker");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGain strength when low on health.");	
        $form->addLabel("§r§a");		
		$form->addLabel("§l§aBlood Berserk");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eReduce the damage of Bloodlost enchantment");			
        $form->addLabel("§r§a");		
		$form->addLabel("§l§aEnlighted");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGain Regeneration when hit.");			
        $form->addLabel("§r§a");	 
		$form->addLabel("§l§aHeavy");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eAxe-inflicted damage is reduced.");			
        $form->addLabel("§r§a");
		$form->addLabel("§l§aKnight");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eChance to gain Invincibility for 5 seconds");			
        $form->addLabel("§r§a");
		$form->addLabel("§l§aObsidian Shield");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eGain Fire Resistance while equipped.");			
        $form->addLabel("§r§a");	
		$form->addLabel("§l§aOverload");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eGives extra health (stackable).");			
        $form->addLabel("§r§a");	
		$form->addLabel("§l§aShielded");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGives Resistance while worn (stackable).");			
        $form->addLabel("§r§a");	
		$form->addLabel("§l§aTank");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eDecreases damage from bows.");			
        $form->addLabel("§r§a");		
		$form->addLabel("§l§aVitamins");
		$form->addLabel("§r§aType: §eArmor");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGrants Immunity to Hunger");			
        $form->addLabel("§r§a");	
		$form->addLabel("§l§aAntitoxin");
		$form->addLabel("§r§aType: §eHelmet");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eGrants immunity to poison.");			
        $form->addLabel("§r§a");
		$form->addLabel("§l§aClarity");
		$form->addLabel("§r§aType: §eHelmet");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eGrants immunity to blindness");			
        $form->addLabel("§r§a");	
		$form->addLabel("§l§aFocused");
		$form->addLabel("§r§aType: §eHelmet");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eNegates or reduces the effects of nausea.");			
        $form->addLabel("§r§aGlowing");
		$form->addLabel("§r§aType: §eHelmet");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eGives Night vision when held");			
        $form->addLabel("§r§a");		
        $form->addLabel("§r§aNourish");
		$form->addLabel("§r§aType: §eHelmet");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eReuces the effects of Wither");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aGears");
		$form->addLabel("§r§aType: §eBoots");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e3");
		$form->addLabel("§r§aDescription: §eGain Speed while equipped.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aSprings");
		$form->addLabel("§r§aType: §eBoots");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e3");
		$form->addLabel("§r§aDescription: §eGain jumpboost while equipped.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aI'm Fast AF Boi");
		$form->addLabel("§r§aType: §eBoots");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eGrants immunity to slowness effect");			
        $form->addLabel("§r§a");
        $form->addLabel("§r§aAerial");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eWhile in air, damage increases.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aBackstab");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eBackstabbing enemies deals increased damage.");			
        $form->addLabel("§r§a");
        $form->addLabel("§r§aBlessed");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGrants a chance to remove harmful effects during combat.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aBlind");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to blind enemies");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aBloodlost");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to inflict massive damage upon hitting enemies.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aCharge");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eDamage increases while sprinting.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aCripple");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eInflicts Nausea and Slowness upon hitting enemy.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aDeathbringer");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eIncreases damage inflicted.");			
        $form->addLabel("§r§a");	
        $form->addLabel("§r§aSpits Web");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to trap enemies with cobwebs");			
        $form->addLabel("§r§aCooldown: §e60 Seconds");
		$form->addLabel("§r§aCosts: §e50,000 EXP");
		$form->addLabel("§r§a");
        $form->addLabel("§r§aLightning");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to strike enemies with lightning.");			
        $form->addLabel("§r§aCooldown: §e20 Seconds");
		$form->addLabel("§r§aCosts: §e50,000 EXP");
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aSilence");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e3");
		$form->addLabel("§r§aDescription: §eRemoves enemies Regeneration");	
        $form->addLabel("§r§aCooldown: §e180 Seconds");		
		$form->addLabel("§r§aCosts: §e50,000 EXP");
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aWovens Fortune");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGains Exp when hitting an enemy");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aHallucination");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to trap enemies into a fake prison");	
        $form->addLabel("§r§aCooldown: §e120 Seconds");		
		$form->addLabel("§r§aCosts: §e50,000 EXP");		
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aShatterglass");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to weaken enemies amor durability");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aVampire");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eConverts damage dealt into health.");	
		$form->addLabel("§r§a");
        $form->addLabel("§r§aRage");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGains strength when held");	
		$form->addLabel("§r§a");		
        $form->addLabel("§r§aPoison");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to inflict enemies poison");	
		$form->addLabel("§r§a");
        $form->addLabel("§r§aWither");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChance to inflict enemies Wither");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aInflux");
		$form->addLabel("§r§aType: §eWeapon");	
        $form->addLabel("§r§aRarity: §eMythic");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eChane to inflicts enemies massive poison, wither");	
		$form->addLabel("§r§aIgnores: §eChance to ignore Antitoxin, Nourish enchants");
		$form->addLabel("§r§a");		
        $form->addLabel("§r§aGrind");
		$form->addLabel("§r§aType: §eTools");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eGains Exp when mining. 5 xp per lvl");	
		$form->addLabel("§r§a");
        $form->addLabel("§r§aWovens Hack");
		$form->addLabel("§r§aType: §eTools");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eChance to auto sell inventory");	
		$form->addLabel("§r§a");
        $form->addLabel("§r§aRage's Fortune");
		$form->addLabel("§r§aType: §eTools");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e10");
		$form->addLabel("§r§aDescription: §eChance to aquire keys when mining");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aTelepathy");
		$form->addLabel("§r§aType: §eTools");	
        $form->addLabel("§r§aRarity: §eCommon");	
		$form->addLabel("§r§aMax Level: §e1");
		$form->addLabel("§r§aDescription: §eWhen mining it directly gives it to your inventory");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aHaste");
		$form->addLabel("§r§aType: §eTools");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eGain Haste while tool is held.");	
		$form->addLabel("§r§a");
        $form->addLabel("§r§aAutorepair");
		$form->addLabel("§r§aType: §eGlobal");	
        $form->addLabel("§r§aRarity: §eUncommon");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eItems automatically repair while moving.");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aSoulbound");
		$form->addLabel("§r§aType: §eGlobal");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e5");
		$form->addLabel("§r§aDescription: §eKeeps item after death, but removes a level from armor.");	
		$form->addLabel("§r§a");	
        $form->addLabel("§r§aLucky Charm");
		$form->addLabel("§r§aType: §eGlobal");	
        $form->addLabel("§r§aRarity: §eRare");	
		$form->addLabel("§r§aMax Level: §e3");
		$form->addLabel("§r§aDescription: §eIncreases activation chance of reactive enchantments.");	
		$form->addLabel("§r§a");			
	    $form->sendToPlayer($player);
	}
}