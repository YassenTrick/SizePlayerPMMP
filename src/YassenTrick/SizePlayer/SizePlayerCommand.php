<?php
declare(strict_types=1);
namespace YassenTrick\SizePlayer;

use pocketmine\{plugin\Plugin, Player};
use pocketmine\command\{Command, CommandSender, PluginIdentifiableCommand};
use pocketmine\utils\TextFormat as TF;

class SizePlayerCommand extends Command implements PluginIdentifiableCommand{

	/** var SizePlayer */
	private $plugin;

	public function __construct(SizePlayer $plugin) {
		$this->plugin = $plugin;
		$this->setPermission("sizeplayer.command");
		parent::__construct("size", "Change your player size!");
	}

	public function execute(CommandSender $sender, string $label, array $args): bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(TF::RED."This command only works in-game");
			return true;
		}
		if(!$this->testPermission($sender)){
			return true;
		}
		if(isset($args[0])) {
			if(is_numeric($args[0])) {
				if($args[0] > 15) {
					$sender->sendMessage(TF::RED. "This size must not bigger than §e15");
					return true;
				}elseif($args[0] < 0.05) {
					$sender->sendMessage(TF::RED. "This size cannot be smaller than §e0.05");
					return true;
				}
				$this->plugin->saveSize($sender->getLowerCaseName(), (float)$args[0]);
				$sender->setScale((float)$args[0]);
				$sender->sendMessage("§8§l(§a!§8)§r §aYou have changed your size to ".TF::GOLD . $args[0]."§a!");
				return true;
			}
			if($args[0] === "reset"){
				$this->plugin->deleteSize($sender->getLowerCaseName());
				$sender->setScale(1);
				$sender->sendMessage("§8§l(§a!§8)§r §aYou have reset your size!");
				return true;
			}
			if($args[0] === "help"){
				$sender->sendMessage("§8» §eCommands Lists! Sizeplayer \n§8» §c/size help §7- if you don`t know the commands!\n§8» §c/size reset §7- This command reset your sizes!\n§8» §c/size (size:number) §7- This command makes you any size!");
				return true;
			}
		}
		$sender->sendMessage(TF::RED."Unknown command, §8» §c/size help §7- if you don`t know the commands!");
		return true;
	}

	public function getPlugin(): Plugin{
		return $this->plugin;
	}
}
