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

class RulesCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("See the rules of the server");
        $this->setUsage("/rules");
		$this->setAliases(["rule"]);
        $this->setPermission("core.rule");
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
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "Rules Server");
		$form->addLabel(TextFormat::YELLOW . "Cheating is not allowed");
		$form->addLabel(TextFormat::YELLOW . "Duping is not allowed");		
		$form->addLabel(TextFormat::YELLOW . "You cannot swear/cuss");
		$form->addLabel(TextFormat::YELLOW . "You cannot use Hack or Cheated Texture pack");
		$form->addLabel(TextFormat::YELLOW . "Do not ask for staff rank or op");
		$form->addLabel(TextFormat::YELLOW . "You cannot abuse glitch");
		$form->addLabel(TextFormat::YELLOW . "Do not Ask Money From Staff");
		$form->addLabel(TextFormat::YELLOW . "Do not Ask Item From Staff");
		$form->addLabel(TextFormat::YELLOW . "Do not ask nonsense questions");
		$form->addLabel(TextFormat::YELLOW . "Do not cause drama in public");
		$form->addLabel(TextFormat::YELLOW . "You cannot fly in combat");
		$form->addLabel(TextFormat::YELLOW . "Do not Ask Personal Information");
		$form->addLabel(TextFormat::YELLOW . "You cannot lie to staff");
		$form->addLabel(TextFormat::YELLOW . "Do not Disrespect Staff");
		$form->addLabel(TextFormat::YELLOW . "Do not advertise a server");
        $form->addLabel(TextFormat::YELLOW . "You can't fly on warzone");
		$form->addLabel(TextFormat::YELLOW . "If you break any rules you will be BANNED!");
	    $form->sendToPlayer($player);
	}
}