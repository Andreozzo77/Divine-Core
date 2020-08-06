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

class StoreCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("List of buycraft store");
        $this->setUsage("/store");
        $this->setPermission("core.store");
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
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§9§lStore");
		$form->addLabel("§r§a§lRanks:");		
        $form->addLabel("§r§6Baron Rank - §a10$");	
        $form->addLabel("§r§6Viscount Rank - §a15$");		
		$form->addLabel("§r§6Emperor Rank - §a20$");
        $form->addLabel("§r§6Divine Rank - §a25$");		
		$form->addLabel("§r§6FOR MORE INFO ABOUT RANKS PLEASE DO §a/premium");	
		$form->addLabel("§r");
		$form->addLabel("§r§a§lMoneys:");
		$form->addLabel("§r§65B Money - §a15$");
		$form->addLabel("§r§610B Money - §a20$");
		$form->addLabel("§r§615B Money - §a25$");
		$form->addLabel("§r§620B Money - §a30$");
		$form->addLabel("§r§625B Money - §a35$");
		$form->addLabel("§r");
		$form->addLabel("§r§a§lSpawners:");
		$form->addLabel("§r§6Elder Guardian Spawners 32x - §a5$");
		$form->addLabel("§r§6Elder Guardian Spawners 64x - §a10$");
		$form->addLabel("§r§6Vex Spawners 32x 15x - §a20$");
		$form->addLabel("§r§6Vex Spawners 64x - §a30$");
		$form->addLabel("§r");
		$form->addLabel("§r§a§lCrate:");	
		$form->addLabel("§r§6Ace Of Joker Crate - §a100$");
		$form->addLabel("§r");
		$form->addLabel("§r§a§lExperience:");	
        $form->addLabel("§r§625M Exp - §a15$");	
        $form->addLabel("§r§645M Exp - §a25$");	
 		$form->addLabel("§r§665M Exp - §a35$");	
		$form->addLabel("§r§6100M Exp - §a50$");	
		$form->addLabel("§r§6");
		$form->addLabel("§r§aIf you wanted to buy any items from the store");    
		$form->addLabel("§r§6Contact the owner §lRage#1234");
	    $form->sendToPlayer($player);
	}
}