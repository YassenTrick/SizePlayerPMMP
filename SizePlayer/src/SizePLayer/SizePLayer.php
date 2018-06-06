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
        $this->getServer()->getCommandMap()->register("size", new Size($this));
    }
    
    public function respawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if(!empty($this->size[$player->getName()])){
            $size = $this->size[$player->getName()];
            $player->setScale($size);
        }
    }
}
class SizePLayer extends Command{
    
    private $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct("size", "Change your size.");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
        if($player->hasPermission("size.command")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
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
            }
        }
    }

        return true;
    }
}
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
        $this->getServer()->getCommandMap()->register("size", new Size($this));
    }
    
    public function respawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if(!empty($this->size[$player->getName()])){
            $size = $this->size[$player->getName()];
            $player->setScale($size);
        }
    }
}
class SizePLayer extends Command{
    
    private $plugin;
    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct("size", "Change your size.");
    }
    
    public function execute(CommandSender $player, string $label, array $args){
        if($player->hasPermission("size.command")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
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
            }
        }
    }
}
