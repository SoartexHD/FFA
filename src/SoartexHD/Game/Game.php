<?php


namespace SoartexHD\Game;


use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\Config;
use SoartexHD\FFA;
use SoartexHD\File\GameConfigs;

class Game
{
    /** @var Player $player */
    private $player;

    /** @var FFA $p */
    private $p;

    /** @var Config $cfg */
    private $cfg;

    /** @var string $path */
    private $path;

    /** @var string $prefix */
    private $prefix;


    /**
     * Game constructor.
     * @param FFA $p
     * @param Player $player
     */
    public function __construct(FFA $p, Player $player)
    {
        $this->p = $p;
        $this->player = $player;
        $this->path = $this->p->getDataFolder() . "config.yml";
        $this->cfg = new Config($this->path, Config::YAML);
        $this->prefix = FFA::PREFIX;
    }

    /**
     *
     */
    public function safezone(){
        $pos = $this->cfg->get("Positions");

        $pos1 = array($pos["POS1"]['X'], $pos["POS1"]['Y'], $pos["POS1"]['Z']);
        $pos2 = array($pos["POS2"]['X'], $pos["POS2"]['Y'], $pos["POS2"]['Z']);

        $x = [$pos1[0], $pos2[0]];
        $y = [$pos1[1], $pos2[1]];
        $z = [$pos1[2], $pos2[2]];

        if($this->player->getX() >= min($x) AND $this->player->getX() <= max($x) AND $this->player->getY() >= min($y) AND $this->player->getY() <= max($y) AND $this->player->getZ() >= min($z) AND $this->player->getZ() <= max($z)){
            if(!in_array($this->player, $this->p->safezone, true)) {
                $this->player->sendMessage($this->prefix . "§cYour are now in the safezone pvp is now disabled!");
                $this->p->safezone[] = $this->player;
            }
        }else{
            if(in_array($this->player, $this->p->safezone, true)) {
                unset($this->p->safezone[array_search($this->player, $this->p->safezone)]);
                $this->player->sendMessage($this->prefix . "§cYou have left the safezone pvp is now again enabled");
            }
        }
    }

    /**
     * @return bool
     */
    public function inZone(){
        return in_array($this->player, $this->p->safezone, true) ? true : false;
    }

}