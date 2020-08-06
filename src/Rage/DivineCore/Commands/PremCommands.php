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

class PremCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("List rank perms");
        $this->setUsage("/premium");
        $this->setPermission("core.asd");
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
		$this->PremUI($sender);
		return true;
	}

	/**
	 * @param RuleUI
	 * @param Player $player
     */
	public function PremUI(Player $player) : void{
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function (Player $player, $data) {
           $result = $data[0];
	    });
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§9§lRanks");
		$form->addLabel("§r§a§lRanks:");		
        $form->addLabel("§r§6Baron Rank:");	
		$form->addLabel("§r§a* /kit Baron");	
		$form->addLabel("§r§a* /tag");	
		$form->addLabel("§r§a* /fly");	
		$form->addLabel("§r§a* /pv 1 - 10");	
		$form->addLabel("§r§a* /nv - night vision");
		$form->addLabel("§r§a* /nick");
		$form->addLabel("§r§a* /realname");
		$form->addLabel("§r§a");
        $form->addLabel("§r§6Viscount Rank:");	
		$form->addLabel("§r§a* /kit Viscount");	
		$form->addLabel("§r§a* /tag");	
		$form->addLabel("§r§a* /fly");	
		$form->addLabel("§r§a* /pv 1 - 20");	
		$form->addLabel("§r§a* /nv - night vision");
		$form->addLabel("§r§a* /nick");
		$form->addLabel("§r§a* /realname");		
		$form->addLabel("§r§6Emperor Rank:");
		$form->addLabel("§r§a* /kit Emperor");	
		$form->addLabel("§r§a* /tag");	
		$form->addLabel("§r§a* /fly");	
		$form->addLabel("§r§a* /pv 1 - 30");	
		$form->addLabel("§r§a* /nv - night vision");
		$form->addLabel("§r§a* /nick");
		$form->addLabel("§r§a* /realname");			
		$form->addLabel("§r§a* /time");	
        $form->addLabel("§r§a* /nt");			
        $form->addLabel("§r§6Divine Rank");
		$form->addLabel("§r§a* /kit Divine");	
		$form->addLabel("§r§a* /tag");	
		$form->addLabel("§r§a* /fly");	
		$form->addLabel("§r§a* /pv 1 - 40");	
		$form->addLabel("§r§a* /nv - night vision");
		$form->addLabel("§r§a* /nick");
		$form->addLabel("§r§a* /realname");			
		$form->addLabel("§r§a* /time");	
        $form->addLabel("§r§a* /nt");	
        $form->addLabel("§r§a* /ranks - Change Divine Rank Name");	
        $form->addLabel("§r§a§lBENIFITS OF DIVINE RANK:");
        $form->addLabel("§r§aEvery new season you will receive 12 Special Enchantment Books.");
	    $form->sendToPlayer($player);
	}
}