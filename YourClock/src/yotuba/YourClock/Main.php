<?php
namespace yotuba\YourClock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;

class Main extends PluginBase implements Listener{
    public function onEnable(){
		$this->getServer()->getPluginmanager()->registerEvents( $this, $this );
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
      }
      return true;
    }
}
