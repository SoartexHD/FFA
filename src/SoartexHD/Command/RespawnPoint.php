<?php


namespace SoartexHD\Command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use SoartexHD\FFA;
use SoartexHD\File\GameConfigs;

class RespawnPoint extends Command
{
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var FFA
     */
    private $p;


    /**
     * @var
     */
    private $cfg;

    /**
     * RespawnPoint constructor.
     * @param FFA $p
     */
    public function __construct(FFA $p){
        parent::__construct("setrespawn");
        $this->setDescription("FFA - Set the respawn point");
        $this->prefix = FFA::PREFIX;
        $this->p = $p;
    }

    /**
     * @param CommandSender $sender
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $label, array $args) : bool
    {
        if($sender instanceof Player) {
            if ($sender->hasPermission("FFA.setup") OR $sender->isOp()) {
                $this->cfg = new GameConfigs($this->p, array($sender->getX(), $sender->getY(), $sender->getZ()));
                $this->cfg->saverespawn();
                $sender->sendMessage($this->prefix . "§cSuccessfuly setted up the respawn point");
            }
        }
        return true;
    }
}