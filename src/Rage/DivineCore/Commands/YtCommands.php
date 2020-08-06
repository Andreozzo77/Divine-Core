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

class YtCommands extends PluginCommand{
	
	/** @var array */
	public $plugin;

	public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Info about youtube");
        $this->setUsage("/yt");
		$this->setAliases(["youtube"]);
        $this->setPermission("core.yt");
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
	    $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§9§lYouTuber");
		$form->addLabel("§r§a§lYouTuber Rank");		
        $form->addLabel("§r§7Q:7 How do i get YouTuber Rank?");	
        $form->addLabel("§r§aA: You need atleast 200 subscribers and the video should be 3 minute mininum");		
		$form->addLabel("§r§7Q: What's on YouTuber Rank?");
        $form->addLabel("§r§aA: OP Kit, nick, vaults 1 - 20, tag, fly");		
		$form->addLabel("§r§7Q: Is My YouTuber Rank will be permanent?");
		$form->addLabel("§r§aA: Yes, as long as you post a video minimum of two videos per week.");
	    $form->sendToPlayer($player);
	}
}