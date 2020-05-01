<?php


namespace SoartexHD\File;


use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use SoartexHD\FFA;

class GameConfigs
{

    /**
     * @var FFA
     */
    private $p;
    /**
     * @var array
     */
    private $pos;

    /**
     * @var string
     */
    private $path;
    /**
     * @var Config
     */
    private $cfg;

    /**
     * GameConfigs constructor.
     * @param FFA $p
     * @param array $pos
     */
    public function __construct(FFA $p, array $pos)
    {
        $this->p = $p;
        $this->pos = $pos;

        $this->path = $this->p->getDataFolder() . "config.yml";
        $this->cfg = new Config($this->path, Config::YAML);
    }

    /**
     *
     */
    public function savepos1(){
        $this->cfg->set("Positions", [
            "POS1" => [
                "X" => $this->pos[0],
                "Y" => $this->pos[1],
                "Z" => $this->pos[2]
            ],
            "POS2" => null
        ]);

        $this->cfg->save();
    }

    /**
     *
     */
    public function savepos2(){
        $this->cfg->set("Positions", [
            "POS1" => $this->cfg->get("Positions")['POS1'],
            "POS2" => [
                "X" => $this->pos[0],
                "Y" => $this->pos[1],
                "Z" => $this->pos[2]
            ]
        ]);
        $this->cfg->save();
    }

    /**
     *
     */
    public function saverespawn(){
        $this->cfg->set("Respawn", [
            "X" => $this->pos[0],
            "Y" => $this->pos[1],
            "Z" => $this->pos[2]
        ]);
        $this->cfg->save();
    }

    /**
     * @return Position
     */
    public function getRespawnPoint(){
        $pos = $this->cfg->get("Respawn");
        return new Position($pos['X'], $pos['Y'], $pos['Z']);
    }

    /**
     * @return bool
     */
    public function pos1isnull(){
        return is_null($this->cfg->get("Positions")['POS1']) ? true : false;
    }

    /**
     * @return bool
     */
    public function respawnnull(){
        return is_null($this->cfg->get("Respawn")) ? true : false;
    }

}