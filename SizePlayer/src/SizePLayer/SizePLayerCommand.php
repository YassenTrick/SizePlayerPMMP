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
  
class SizePLayerCommand extends Command{
    
    /** var Plugin */
    private $plugin;
  
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct("size", "Change your player size!");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
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
                    $player->sendMessage("§1- §aYour size now is ".TF::GOLD . $args[0]."§6!");
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
              $player->sendMessage(TF::RED. "The size must be a valid number!");
            }
            return true;
        }
        $player->sendMessage(TF::RED. "You do not have permission allowed to use size command!");
    }
}
