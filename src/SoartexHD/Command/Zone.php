<?php

namespace SoartexHD\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Player;
use SoartexHD\FFA;
use SoartexHD\File\GameConfigs;

class Zone extends Command
{

    /**
     * @var FFA
     */
    private $p;
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var
     */
    private $cfg;

    /**
     * Zone constructor.
     * @param FFA $p
     */
    public function __construct(FFA $p){
        parent::__construct("zone");
        $this->setAliases(["zone"]);
        $this->setDescription("FFA - Set the safezone");
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
                if (empty($args[0])) {
                    $sender->sendMessage($this->prefix . "§euse: §f/zone <pos1 | pos2> \n §4NOTE! pos1 is on the high position and pos2 is on the lowers position");
                } else {
                    if ($args[0] == strtolower("pos1")) {
                        $this->cfg = new GameConfigs($this->p, array($sender->getX(), $sender->getX(), $sender->getZ()));
                        $this->cfg->savepos1();
                        $sender->sendMessage($this->prefix . "§cSuccessfull setted up pos1");
                    } elseif ($args[0] == strtolower("pos2")) {
                        $this->cfg = new GameConfigs($this->p, array($sender->getX(), $sender->getY(), $sender->getZ()));
                        if ($this->cfg->pos1isnull() == false) {
                            $this->cfg->savepos2();
                            $sender->sendMessage($this->prefix . "§cSuccessfull setted up pos2");
                        } else {
                            $sender->sendMessage($this->prefix . "§cPlease first use /zone pos1 and then pos2");
                        }
                    }
                }
            }
        }
        return true;
    }

}