<?php

namespace SixpennyYard\EasyInterface\form;

use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\item\StringToItemParser;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use SixpennyYard\EasyInterface\form\FormAPI\ModalForm;
use SixpennyYard\EasyInterface\FormManager;

class NewModalForm
{
    /**
     * @var ModalForm
     */
    public ModalForm $modalForm;

    /**
     * @param string $title
     * @param $button1
     * @param $button2
     * @param string $content
     */
    public function __construct(string $title, $button1, $button2, string $content = "You should set a content to change this text !!!")
    {
        $this->NewModalForm($title, $content, $button1, $button2);
    }

    /**
     * @param string $title
     * @param string $content
     * @param mixed $button1
     * @param mixed $button2
     * @return void
     */
    private function NewModalForm(string $title, string $content, mixed $button1, mixed $button2): void
    {
        $form = new ModalForm(function(Player $player, $data, $button1, $button2){
            if($data === true){
                if (!$button1['onclick'] == null)
                {
                    $sendAction = implode(":", $button1['onclick']);
                    if (str_contains($button1['onclick'], "send"))
                    {
                        if ($sendAction[1] == "interact")
                        {
                            $form = FormManager::getInstance()->getFormByTitle($sendAction[2]);
                            $player->sendForm($form);
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->sendMessage($sendAction[2]);
                        }
                    }
                    elseif (str_contains($button1['onclick'], "transfer"))
                    {
                        if ($sendAction[1] == "interact")
                        {
                            if (isset($sendAction[3]))
                            {
                                $player->transfer($sendAction[2], $sendAction[3]);
                            }
                            else
                            {
                                $player->transfer($sendAction[2]);
                            }
                        }
                        elseif ($sendAction[1] == "everyone")
                        {
                            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer)
                            {
                                if (isset($sendAction[3]))
                                {
                                    $onlinePlayer->transfer($sendAction[2], $sendAction[3]);
                                }
                                else
                                {
                                    $onlinePlayer->transfer($sendAction[2]);
                                }
                            }
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            if (isset($sendAction[3]))
                            {
                                $target->transfer($sendAction[2], $sendAction[3]);
                            }
                            else
                            {
                                $target->transfer($sendAction[2]);
                            }
                        }
                    }elseif (str_contains($button1['onclick'], "give"))
                    {
                        if ($sendAction[1] == "everyone")
                        {
                            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer)
                            {
                                try
                                {
                                    $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                                }
                                catch(LegacyStringToItemParserException){
                                    $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                    return true;
                                }
                                $item->setCount($sendAction[3]);
                                $onlinePlayer->getInventory()->addItem($item);
                            }
                        }
                        elseif ($sendAction[1] == "target")
                        {
                            try
                            {
                                $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                            }
                            catch(LegacyStringToItemParserException)
                            {
                                $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                return true;
                            }
                            $item->setCount($sendAction[3]);
                            $player->getInventory()->addItem($item);
                        }
                        else
                        {
                            try
                            {
                                $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                            }
                            catch(LegacyStringToItemParserException)
                            {
                                $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                return true;
                            }
                            $item->setCount($sendAction[3]);
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->getInventory()->addItem($item);
                        }
                    }
                    elseif (str_contains($button1['onclick'], "say"))
                    {
                        if ($sendAction[1] == "everyone")
                        {
                            Server::getInstance()->broadcastMessage($sendAction[2]);
                        }
                        elseif ($sendAction[1] == "interact")
                        {
                            $player->sendMessage($sendAction[2]);
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->sendMessage($sendAction[2]);
                        }
                    }
                }
            }
            else
            {
                if (!$button2['onclick'] == null)
                {
                    $sendAction = implode(":", $button1['onclick']);
                    if (str_contains($button1['onclick'], "send"))
                    {
                        if ($sendAction[1] == "interact")
                        {
                            $form = FormManager::getInstance()->getFormByTitle($sendAction[2]);
                            $player->sendForm($form);
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->sendMessage($sendAction[2]);
                        }
                    }
                    elseif (str_contains($button1['onclick'], "transfer"))
                    {
                        if ($sendAction[1] == "interact")
                        {
                            if (isset($sendAction[3]))
                            {
                                $player->transfer($sendAction[2], $sendAction[3]);
                            }
                            else
                            {
                                $player->transfer($sendAction[2]);
                            }
                        }
                        elseif ($sendAction[1] == "everyone")
                        {
                            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer)
                            {
                                if (isset($sendAction[3]))
                                {
                                    $onlinePlayer->transfer($sendAction[2], $sendAction[3]);
                                }
                                else
                                {
                                    $onlinePlayer->transfer($sendAction[2]);
                                }
                            }
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            if (isset($sendAction[3]))
                            {
                                $target->transfer($sendAction[2], $sendAction[3]);
                            }
                            else
                            {
                                $target->transfer($sendAction[2]);
                            }
                        }
                    }elseif (str_contains($button1['onclick'], "give"))
                    {
                        if ($sendAction[1] == "everyone")
                        {
                            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer)
                            {
                                try
                                {
                                    $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                                }
                                catch(LegacyStringToItemParserException){
                                    $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                    return true;
                                }
                                $item->setCount($sendAction[3]);
                                $onlinePlayer->getInventory()->addItem($item);
                            }
                        }
                        elseif ($sendAction[1] == "target")
                        {
                            try
                            {
                                $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                            }
                            catch(LegacyStringToItemParserException)
                            {
                                $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                return true;
                            }
                            $item->setCount($sendAction[3]);
                            $player->getInventory()->addItem($item);
                        }
                        else
                        {
                            try
                            {
                                $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                            }
                            catch(LegacyStringToItemParserException)
                            {
                                $player->sendMessage(KnownTranslationFactory::commands_give_item_notFound($sendAction[2])->prefix(TextFormat::RED));
                                return true;
                            }
                            $item->setCount($sendAction[3]);
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->getInventory()->addItem($item);
                        }
                    }
                    elseif (str_contains($button1['onclick'], "say"))
                    {
                        if ($sendAction[1] == "everyone")
                        {
                            Server::getInstance()->broadcastMessage($sendAction[2]);
                        }
                        elseif ($sendAction[1] == "interact")
                        {
                            $player->sendMessage($sendAction[2]);
                        }
                        else
                        {
                            $target = Server::getInstance()->getPlayerExact($sendAction[1]);
                            $target->sendMessage($sendAction[2]);
                        }
                    }
                }
            }
        });

        $form->setTitle($title);
        $form->setContent($content);
        $form->setButton1($button1['name']);
        $form->setButton2($button2['name']);
    }
}