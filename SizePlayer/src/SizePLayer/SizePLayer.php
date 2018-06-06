<?php
namespace SizePLayer;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Server;
use pocketmine\Player;
class SizePLayer extends PluginBase{
    
    public $size = array();
    public function onEnable(){
        $this->getLogger()->info("§aEnabling plugin...");
        $this->getLogger()->notice("§bSizePlayer v1 succesfully enabled!!");
        #$this->getServer()->getCommandMap()->register("size", new Size($this));
    }
    
    public function respawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if(!empty($this->size[$player->getName()])){
            $size = $this->size[$player->getName()];
            $player->setScale($size);
        }
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        if($sender->hasPermission("size.command")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
                    $this->size[$sender->getName()] = $args[0];
                    $sender->setScale($args[0]);
                    $sender->sendMessage("§1- §aYour size now is ".$args[0]."!");
                }elseif($args[0] == "reset"){
                    if(!empty($this->size[$sender->getName()])){
                        unset($this->size[$sender->getName()]);
                        $sender->setScale(1);
                        $sender->sendMessage("§1- §aYour size is now normal!");
                    }else{
                        $sender->sendMessage("§1- §aYour size has been reset!!");
                    }
                }else{
                    $sender->sendMessage("§8» §eCommands Lists! Sizeplayer \n§8» §c/size help §7- if you don`t know the commands!\n§8» §c/size reset §7- This command reset your sizes!\n§8» §c/size (size:number) §7- This command makes you any size!");
                }
            }
        }
    }
}
