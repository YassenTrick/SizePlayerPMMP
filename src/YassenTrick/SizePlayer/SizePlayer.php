<?php
declare(strict_types=1);
namespace YassenTrick\SizePlayer;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\{PlayerJoinEvent, PlayerRespawnEvent};;

class SizePlayer extends PluginBase implements Listener {

	/** @var Array<string, float> */
	private $data;

	public function onEnable(): void{
		$this->getServer()->getCommandMap()->register("sizeplayer", new SizePlayerCommand($this));
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if(!$this->checkLegacyData()) $this->loadData();
	}

	public function onDisable(): void{
		$this->saveData();
	}

	private function checkLegacyData(): bool{
		if(file_exists($this->getDataFolder()."data.yml")){
			//["version" => 1, "sizes" => []] Old format...
			$data = yaml_parse_file($this->getDataFolder()."data.yml");
			rename($this->getDataFolder()."data.yml", $this->getDataFolder()."data.yml.OLD");
			if($data !== false and is_array($data["sizes"]??null)){
				$this->data = $data["sizes"];
				$this->saveData();
				$this->getLogger()->info("Converted old data to new file data.json, old data can be found in data.yml.OLD");
				return true;
			}
		}
		return false;
	}

	public function saveData(): void{
		if(file_put_contents($this->getDataFolder()."data.json", json_encode($this->data)) === false){
			$this->getLogger()->error("Failed to save data.");
		}
	}

	public function loadData(): void{
		if(!file_exists($this->getDataFolder()."data.json")){
			$this->data = [];
			$this->saveData();
			return;
		}
		$this->data = json_decode(file_get_contents($this->getDataFolder()."data.json"));
		if($this->data === null){
			$this->getLogger()->warning("Failed to load data, reset to []");
			$this->data = [];
			$this->saveData();
		}
	}

	public function getSize(string $name): ?float{
		return $this->data[$name]??null;
	}

	public function saveSize(string $name, float $size): void{
		$this->data[$name] = $size;
	}

	public function deleteSize(string $name): void{
		unset($this->data[$name]);
	}

	public function onPlayerJoin(PlayerJoinEvent $ev): void{
		$p = $ev->getPlayer();
		if(($size = $this->getSize($p->getLowerCaseName())) !== null){
			$p->setScale($size);
		}
	}

	public function onPlayerRespawn(PlayerRespawnEvent $ev): void{
		$p = $ev->getPlayer();
		if(($size = $this->getSize($p->getLowerCaseName())) !== null){
			$p->setScale($size);
		}
	 }
}
