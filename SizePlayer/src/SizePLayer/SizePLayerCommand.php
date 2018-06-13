<?php

namespace SizePLayer;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Server;
use pocketmine\Player;
  
class SizePLayerCommand extends Command{
    
    private $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct("size", "Change your size.");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
        if(!$player instanceof Player){
			$player->sendMessage(C::RED."This command only works in-game");
			return;
		}
        if($player->hasPermission("size.command")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
                    if($args[0] > 20){
                      $player->sendMessage("Size cannot be bigger then 20");
                      return true;
                    }elseif($args[0] <= 0){
                      $player->sendMessage("Size cannot be smaller than or eqaul to 0");
                      return true;
                    }
                    $this->plugin->size[$player->getName()] = $args[0];
                    $player->setScale($args[0]);
                    $player->sendMessage("§1- §aYour size now is ".$args[0]."!");
                }elseif($args[0] == "reset"){
                    if(!empty($this->plugin->size[$player->getName()])){
                        unset($this->plugin->size[$player->getName()]);
                        $player->setScale(1);
                        $player->sendMessage("§1- §aYour size is now normal!");
                    }else{
                        $player->sendMessage("§1- §aYour size has been reset!!");
                    }
                }else{
                    $player->sendMessage("§8» §eCommands Lists! Sizeplayer \n§8» §c/size help §7- if you don`t know the commands!\n§8» §c/size reset §7- This command reset your sizes!\n§8» §c/size (size:number) §7- This command makes you any size!");
                }
            } else {
              $player->sendMessage("The size must be a number");
            }
            return true;
        }
        $player->sendMessage("You do not have permission to do this.");
    }
}
