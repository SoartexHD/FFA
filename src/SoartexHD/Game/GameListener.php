<?php

namespace SoartexHD\Game;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use SoartexHD\File\GameConfigs;
use SoartexHD\Item\Items;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use SoartexHD\File\PlayerConfigs;
use SoartexHD\FFA;

class GameListener implements Listener
{
    /** @var FFA  */
    private $main;

    /**
     * GameListener constructor.
     * @param FFA $main
     */
    public function __construct(FFA $main)
    {
        $this->main = $main;
    }

    /**
     * @param PlayerLoginEvent $ev
     */
    public function onLogin(PlayerLoginEvent $ev){
        $player = $ev->getPlayer();

        //CFG'S
        $cfg = new PlayerConfigs($this->main, $player);
        $cfg->createFiles();
    }

    /**
     * @param PlayerJoinEvent $ev
     */
    public function onJoin(PlayerJoinEvent $ev){
        $player = $ev->getPlayer();
        $ev->setJoinMessage($this->main->getPrefix() . "§e" . $player->getDisplayName() . " §ajoined the game.");

        $items = new Items($this->main, $player);
        $items->getStartItems();
    }

    /**
     * @param PlayerQuitEvent $ev
     */
    public function onQuit(PlayerQuitEvent $ev){
        $player = $ev->getPlayer();
        $ev->setQuitMessage($this->main->getPrefix() . "§e" . $player->getDisplayName() . " §chas left the game.");
    }

    /**
     * @param PlayerDeathEvent $ev
     */
    public function onDamage(PlayerDeathEvent $ev){
        $player = $ev->getPlayer();
        $victim = $ev->getEntity();

        $ev->setDrops(array()); //DISABLE DROP ITEMS AFTER DEATH

        if($player instanceof Player and $victim instanceof Player)
            $cause = $victim->getLastDamageCause();
            if($cause instanceof EntityDamageByEntityEvent){
                $killer = $cause->getDamager();
                if($killer !== null) {
                    if ($killer instanceof Player) {

                        $cfg = new PlayerConfigs($this->main, $killer);
                        $cfg->addKill();

                        $cfgvictim = new PlayerConfigs($this->main, $victim);
                        $cfgvictim->addTod();

                        $ev->setDeathMessage($this->main->getPrefix() . $victim->getName() . " §ewas slained by§3 " . $killer->getName());
                    }
                }else{
                    $cfgvictim = new PlayerConfigs($this->main, $victim);
                    $cfgvictim->addTod();

                    $ev->setDeathMessage($this->main->getPrefix() . $victim->getName() . " §edied.");
                }
            }
        return;
    }

    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function onHit(EntityDamageByEntityEvent $event){
        $player = $event->getEntity();

        if($player instanceof Player)
            $game = new Game($this->main, $player);
            if($game->inZone() == true){
                $event->setCancelled(true);
            }else{
                $event->setCancelled(false);
            }
        return;
    }

    /**
     * @param PlayerMoveEvent $event
     */
    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $game = new Game($this->main, $player);
        $game->safezone();
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBlockBreak(BlockBreakEvent $event){

        $event->setCancelled(true);
    }

    /**
     * @param PlayerRespawnEvent $event
     */
    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        $cfg = new GameConfigs($this->main, []);
        $items = new Items($this->main, $player);

        if($cfg->respawnnull() == true){
            foreach ($this->main->getServer()->getOnlinePlayers() as $admin){
                if($admin->isOp()){
                    $admin->sendMessage($this->main->getPrefix() . "§cthe respawn point is not setted up currenlty please use: /setrespawn to set the respawn point");
                }
            }
        }else{
            $event->setRespawnPosition($cfg->getRespawnPoint());
            $items->getStartItems();
        }
    }

    /**
     * @param PlayerDropItemEvent $event
     */
    public function setDrops(PlayerDropItemEvent $event){
        $event->setCancelled(true);
    }

}