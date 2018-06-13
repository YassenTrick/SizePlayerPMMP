<?php

declare(strict_types=1);
namespace SizePLayer;

use pocketmine\{
  Server, Player
};
use pocketmine\command\{
  Command, CommandSender
};
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Entity;
  
class SizePLayerCommand extends Command {
    
    /** var Plugin */
    private $plugin;
  
    public function __construct($plugin) {
        $this->plugin = $plugin;
        parent::__construct("size", "Change your player size!");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
        if(!$player instanceof Player){
			$player->sendMessage(C::RED."This command only works in-game");
			return;
		}
        if($player->hasPermission("size.command")) {
            if(isset($args[0])) {
                if(is_numeric($args[0])) {
                    if($args[0] > 15) {
                      $player->sendMessage(TF::RED. "This size must not bigger than §e15");
                      return true;
                    }elseif($args[0] <= 0) {
                      $player->sendMessage(TF::RED. "This size cannot be smaller than or equal to §e0");
                      return true;
                    }
                    $this->plugin->size[$player->getName()] = $args[0];
                    $player->setScale($args[0]);
                    $player->sendMessage("§8§l(§a!§8)§r §aYou have changed your size to ".TF::GOLD . $args[0]."§a!");
                }elseif($args[0] == "reset") {
                    if(!empty($this->plugin->size[$player->getName()])) {
                        unset($this->plugin->size[$player->getName()]);
                        $player->setScale(1);
                        $player->sendMessage("§8§l(§a!§8)§r §aYou size has back to normal!");
                    }else{
                        $player->sendMessage("§8§l(§a!§8)§r §aYou have reseted your size!");
                    }
                }else{
                    $player->sendMessage("§8» §eCommands Lists! Sizeplayer \n§8» §c/size help §7- if you don`t know the commands!\n§8» §c/size reset §7- This command reset your sizes!\n§8» §c/size (size:number) §7- This command makes you any size!");
                }
            } else {
              $player->sendMessage(TF::RED. "The size is not a valid number!");
            }
            return true;
        }
        $player->sendMessage(TF::RED. "You do not have permission allowed to use size command!");
    }
}
