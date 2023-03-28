<?php

namespace SixpennyYard\EasyInterface\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEntityInteractEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\ClosureTask;
use SixpennyYard\EasyInterface\exception\FormName;
use SixpennyYard\EasyInterface\FormManager;
use SixpennyYard\EasyInterface\Main;

class Events implements Listener
{
    /***
     * @param PlayerJoinEvent $event
     * @return void
     */
    protected function onJoin(PlayerJoinEvent $event): void
    {
        $config = Main::getInstance()->getConfigFile("interfaces");
        foreach ($config['events'] as $evt)
        {
            if ($evt['event'] == "join")
            {
                Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use($event, $evt): void{
                    FormManager::getInstance()->sendFormToPlayer($event->getPlayer(), $evt['sendForm']);
                }), 10);
            }
        }
    }

    /**
     * @param PlayerInteractEvent $event
     * @return void
     * @throws FormName
     */
    protected function onClick(PlayerInteractEvent $event): void
    {
        $config = Main::getInstance()->getConfigFile("interfaces");
        foreach ($config['events'] as $evt)
        {
            if ($evt['event'] == "interact")
            {
                if (strtolower($event->getBlock()->getName()) === strtolower($evt['with']))
                {
                    FormManager::getInstance()->sendFormToPlayer($event->getPlayer(), $evt['sendForm']);
                }
            }
        }
    }

    /**
     * @param PlayerItemUseEvent $event
     * @return void
     * @throws FormName
     */
    protected function onItemUse(PlayerItemUseEvent $event): void
    {
        $config = Main::getInstance()->getConfigFile("interfaces");
        foreach ($config['events'] as $evt)
        {
            if ($evt['event'] == "itemUse")
            {
                if (strtolower($event->getItem()->getName()) === strtolower($evt['item']))
                {
                    FormManager::getInstance()->sendFormToPlayer($event->getPlayer(), $evt['sendForm']);
                }
            }
        }
    }

    /**
     * @param PlayerEntityInteractEvent $event
     * @return void
     * @throws FormName
     */
    protected function onInteractEntity(PlayerEntityInteractEvent $event): void
    {
        $config = Main::getInstance()->getConfigFile("interfaces");
        foreach ($config['events'] as $evt)
        {
            if ($evt['event'] == "interactEntity")
            {
                if (strtolower($event->getEntity()->getNameTag()) === strtolower($evt['entityName']))
                {
                    FormManager::getInstance()->sendFormToPlayer($event->getPlayer(), $evt['sendForm']);
                }
            }
        }
    }
}