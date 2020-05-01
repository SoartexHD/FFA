<?php

namespace SoartexHD\File;

use pocketmine\Player;
use pocketmine\utils\Config;
use SoartexHD\FFA;

class PlayerConfigs
{
    /** @var Player $p */
    private $p;

    /** @var Player $player */
    private $player;

    /** @var string $name */
    private $name;

    /** @var string $path */
    private $path;

    /** @var Config $cfg */
    private $cfg;

    /**
     * @var int
     */
    private $kills = 0;
    /**
     * @var int
     */
    private $streak = 0;
    /**
     * @var int
     */
    private $tode = 0;

    /**
     * PlayerConfigs constructor.
     * @param FFA $p
     * @param Player $player
     */
    public function __construct(FFA $p, Player $player)
    {
        $this->p = $p;
        $this->player = $player;
        $this->name = $this->player->getName();
        $this->path = $this->p->getDataFolder() . "/players/" . strtolower($this->name) . ".yml";
        $this->cfg = new Config($this->path, Config::YAML);
        $this->kills = $this->cfg->get("Stats")['Kills'];
        $this->streak = $this->cfg->get("Stats")['Streak'];
        $this->tode = $this->cfg->get("Stats")['Tode'];
    }


    /**
     * @return bool
     */
    private function fileExists(){
        return file_exists($this->path) ? true : false;
    }

    /**
     *
     */
    public function createFiles(){
        if($this->fileExists() == false){
            $this->cfg->set("Stats",
                [
                'Tode' => 0,
                'Kills' => 0,
                'Streak' => 0
                ]
            );
            $this->cfg->save();
        }else{
            return;
        }
    }

    /**
     * @return int
     */
    public function getKills(){
        return $this->kills;
    }

    /**
     *
     */
    public function addKill(){
        $this->kills++;
        $this->streak++;
        $this->save();
    }

    /**
     *
     */
    public function addTod(){
        $this->tode++;
        $this->save();
    }

    /**
     *
     */
    public function save(){
        $this->cfg->set("Stats", ['Tode' => $this->tode, 'Kills' => $this->kills, 'Streak' => $this->streak]);
        $this->cfg->save();
    }
}