<?php
declare(strict_types=1);
namespace SizePLayer;
use pocketmine\plugin\{
    PluginBase, Plugin
};
use pocketmine\command\{
    Command, CommandSender
};
use pocketmine\{
    Server, Player
};
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Entity;
use SizePLayer\SizePLayerCommand;
class SizePLayer extends PluginBase {
    
    /** var $size */
    public $size = array();
    
    public function onEnable(): void{
        $this->getLogger()->info("SizePlayer plugin is successfully enabled!");
        $this->getServer()->getCommandMap()->register("size", new SizePLayerCommand($this));
    }
    
    public function onDisable(): void{
        $this->getLogger()->info("SizePlayer plugin is currently disabled!");
    }
    
    public function onPlayerRespawn(PlayerRespawnEvent $ev): void{
        $player = $ev->getPlayer();
        // SIZE EVENT \\
        if(!empty($this->size[$player->getName()])){
            $size = $this->size[$player->getName()];
            $player->setScale($size);
         }
     }
}
