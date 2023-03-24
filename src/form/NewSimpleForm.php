<?php

namespace SixpennyYard\EasyInterface\form;

use pocketmine\player\Player;
use pocketmine\Server;
use SixpennyYard\EasyInterface\form\FormAPI\SimpleForm;
use SixpennyYard\EasyInterface\FormManager;

class NewSimpleForm
{
    public SimpleForm $simpleForm;

    public function __construct(string $title, string $content = null, $buttons = null)
    {
        $this->NewSimpleForm($title, $content, $buttons);
    }

    private function NewSimpleForm(string $title, ?string $content, mixed $buttons): void
    {

        $form = new SimpleForm(function(Player $player, $data, $buttons)
        {
            $case = 0;
            foreach ($buttons as $button)
            {
                if (!$button['onclick'] == null)
                {
                    if($data === null)
                    {
                        return;
                    }
                    if ($data == $case)
                    {
                        $sendAction = implode(":", $button['onclick']);
                        if (str_contains($button['onclick'], "send"))
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
                        elseif (str_contains($button['onclick'], "transfer"))
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
                        }elseif (str_contains($button['onclick'], "give"))
                        {
                            if ($sendAction[1] == "everyone")
                            {
                                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer)
                                {
                                    //TODO: give
                                    try{
                                        $item = StringToItemParser::getInstance()->parse($sendAction[2]) ?? LegacyStringToItemParser::getInstance()->parse($sendAction[2]);
                                    }catch(LegacyStringToItemParserException $e){
                                        $sender->sendMessage(KnownTranslationFactory::commands_give_item_notFound($args[1])->prefix(TextFormat::RED));
                                        return true;
                                    }
                                    $item->setCount($sendAction[3]);
                                    $onlinePlayer->getInventory()->addItem($item);
                                }
                            }
                        }elseif (str_contains($button['onclick'], "say"))
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
                $case += 1;
            }
        });
        $form->setTitle($title);
        if (!$content == null)
        {
            $form->setContent($content);
        }
        foreach ($buttons as $button)
        {
            if (!$button == null)
            {
                if (!$button['image'] == null)
                {
                    $form->addButton($button['name'], 0, $button['image']);
                } else
                {
                    $form->addButton($button['name']);
                }
            }
        }
        $this->simpleForm[$title] = $form;
    }

}
