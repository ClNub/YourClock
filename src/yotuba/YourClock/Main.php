<?php
namespace yotuba\YourClock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener{

    private $conf;

    public function onEnable(){
      $this->getServer()->getPluginmanager()->registerEvents($this, $this);
      $this->conf = new Config($this->getDataFolder().'firsttime.yml', Config::YAML, []);
    }

    public function getConfigData(): Config{
      return $this->conf;
    }

    public function onJoin(PlayerJoinEvent $event){
      $player = $event->getPlayer();
      $name = $player->getName();
      $config = $this->getConfigData();
      if(!$config->exists($name)){
        $date = date("Y/m/d H:i:s");
        $config->set($name, $date);
      }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
      if(!$sender instanceof Player){
        $sender->sendMessage("§e[WARNING]§6 ゲーム内で実行してください");
        return true;
      }

      switch(strtolower($label)){
          case "now":
            $date = date("Y/m/d H:i:s");
            $sender->sendMessage(">>§b ".$date);
            break;

          case "firsttime":
            $name = $sender->getName();
            $config = $this->getConfigData();
            $firstTime = $config->get($name);
            $sender->sendMessage(">> §e[§6".$name."§e] §b".$firstTime);
            break;
      }
      return true;
    }

    public function onDisable(){
      $config = $this->getConfigData();
      $config->save();
    }
}
