<?php

namespace SoartexHD\Item;

use pocketmine\item\Item;
use pocketmine\Player;
use SoartexHD\FFA;

class Items
{

    /** @var Player $p */
    private $p;

    /** @var Player $player */
    private $player;

    /**
     * Items constructor.
     * @param FFA $p
     * @param Player $player
     */
    public function __construct(FFA $p, Player $player)
    {
        $this->p = $p;
        $this->player = $player;
    }

    /**
     *
     */
    public function getStartItems(){
        $inv = $this->player->getInventory();
        $armorinv = $this->player->getArmorInventory();

        //RÜSTUNG
        $armorinv->setHelmet(Item::get(298));
        $armorinv->setChestplate(Item::get(299));
        $armorinv->setLeggings(Item::get(300));
        $armorinv->setBoots(Item::get(301));

        //ITEMS
        $inv->clearAll();
        $inv->setItem(0, Item::get(267)->setCustomName("§bSchwert"));
        $inv->setItem(1, Item::get(261)->setCustomName("§bBogen"));
        $inv->setItem(2, Item::get(17, 1, 64)->setCustomName("§bHolz"));
        $inv->setItem(3, Item::get(262, 1, 16)->setCustomName("§bPfeile"));
        $inv->setItem(4, Item::get(364, 1, 32)->setCustomName("§bSchnitzel"));
        $inv->setItem(5, Item::get(322, 1, 16)->setCustomName("§bSchnitzel"));
        $inv->setItem(7, Item::get(258)->setCustomName("§bAxt"));
        $inv->setItem(8, Item::get(257)->setCustomName("§bSpitzhacke"));
    }

}