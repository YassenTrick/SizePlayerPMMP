<?php
declare(strict_types=1);
namespace SizePLayer;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use pocketmine\Player;
use pocketmine\event\player\{PlayerJoinEvent, PlayerRespawnEvent};;

class SizePLayer extends PluginBase implements Listener {
    
    public function onEnable(): void{
        //no start message in compliance with poggit rules.
        $this->getServer()->getCommandMap()->register("size", new SizePLayerCommand($this));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->dataFile = new Config($this->getDataFolder() . "data.yml", Config::YAML, ["version" => 1, "sizes" => []]);
        $this->data = $this->dataFile->getAll();
    }
    
    public function onDisable(): void{
        $this->getLogger()->info("SizePlayer plugin is currently disabled!");
    }
    
    public function saveData(){
		$this->dataFile->setAll($this->data);
		$this->dataFile->save();
	}
	
	public function updateSize(Player $player, float $size, bool $save = true): void{
		$this->data["sizes"][$player->getLowerCaseName()] = $size;
		$player->setScale($size);
		if($save === true) $this->saveData();
	}
    
    public function onPlayerJoin(PlayerJoinEvent $ev): void{
        $player = $ev->getPlayer();
		if(!empty($this->data["sizes"][$player->getLowerCaseName()])){
            $this->updateSize($player, (float)$this->data["sizes"][$player->getLowerCaseName()], false);
        }
    }
    
    public function onPlayerRespawn(PlayerRespawnEvent $ev): void{
        $player = $ev->getPlayer();
        if(!empty($this->data["sizes"][$player->getLowerCaseName()])){
            $this->updateSize($player, (float)$this->data["sizes"][$player->getLowerCaseName()], false);
        }
     }
}
