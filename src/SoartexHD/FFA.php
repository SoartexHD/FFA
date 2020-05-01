<?php

namespace SoartexHD;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use SoartexHD\Command\RespawnPoint;
use SoartexHD\Command\Zone;
use SoartexHD\File\PlayerConfigs;
use SoartexHD\Game\GameListener;

class FFA extends PluginBase implements Listener
{
    /**
     *
     */
    const PREFIX = "§7[§aFFA§7] §8> ";
    /**
     * @var array
     */
    public $safezone = [];

    /**
     *
     */
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new GameListener($this), $this);
        $this->getLogger()->info(self::PREFIX . "§6aktiviert...");

        //FOULDER'S
        $this->createFoulders();

        //DEFAULT CONFIG'S
        $this->createDefaultConfig();

        //INIT CMD'S
        $this->initCommands();
    }

    /**
     *
     */
    private function initCommands(){
        $this->getServer()->getCommandMap()->register("zone", new Zone($this));
        $this->getServer()->getCommandMap()->register("setrespawn", new RespawnPoint($this));
    }

    /**
     *
     */
    private function createFoulders(){
        if($this->isDir() == false) {
            @mkdir($this->getDataFolder() . "/players/");
            $this->getLogger()->info(self::PREFIX . "§eFoulders created...");
        }else{
            return;
        }
    }

    /**
     *
     */
    private function createDefaultConfig(){
        if($this->cfgexists() == false) {
            $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
            $cfg->set("Positions", array(
                "POS1" => null,
                "POS2" => null
            ));
            $cfg->set("Respawn", null);
            $cfg->save();

            $this->getLogger()->info(self::PREFIX . "§eConfigs created...");
        }else{
            return;
        }
    }

    /**
     * @return bool
     */
    private function isDir(){
        return is_dir($this->getDataFolder() . "/players/") ? true : false;
    }

    /**
     * @return bool
     */
    private function cfgexists(){
        return file_exists($this->getDataFolder() . "config.yml") ? true : false;
    }

    /**
     * @return string
     */
    public function getPrefix(){
        return self::PREFIX;
    }

}