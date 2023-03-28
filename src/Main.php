<?php

namespace SixpennyYard\EasyInterface;


use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

final class Main extends PluginBase {

    CONST CONFIG =
        [
            "interfaces" => [
                [
                    "title" => "NewForm",
                    "type" => "simple",
                    "content" => "Create new form",
                    "button" => [
                        [
                            "name" => "simple",
                            "image" => null,
                            "onclick" => "send:delform"
                        ],
                        [
                            "name" => "custom",
                            "image" => null,
                            "onclick" => null
                        ],
                        [
                            "name" => "modal",
                            "image" => null,
                            "onclick" => null
                        ]
                    ],
                ],
                [
                    "title" => "ModalForm",
                    "type" => "modal",
                    "content" => "Create new modal form",
                    "button1" => [
                        "name" => "yes",
                        "onclick" => "send:delform"
                    ],
                    "button2" => [
                        "name" => "no",
                        "onclick" => null
                    ]
                ],
                [
                    "title" => "DelForm",
                    "type" => "simple",
                    "content" => null,
                    "button" => null

                ]
            ],
            "commands" => [
                [
                    "fallbackPrefix" => "addForm",
                    "name" => "addform",
                    "description" => "Add a form",
                    "usage" => "/addform",
                    "sendForm" => "ModalForm"
                ],
                [
                    "fallbackPrefix" => "delForm",
                    "name" => "delform",
                    "description" => "Del a form",
                    "usage" => "/delform",
                    "sendForm" => "NewForm"
                ]
            ],
            "events" => [
                [
                    "event" => "interact",
                    "with" => "stone",
                    "sendForm" => "ModalForm"
                ],
                [
                    "event" => "itemUse",
                    "item" => "dirt",
                    "sendForm" => "NewForm"
                ]
            ]
        ];
    /**
     * @var Main
     */
    private static Main $main;

    /**
     * @return Main
     */
    public static function getInstance(): Main
    {
        return self::$main;
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function onEnable(): void
    {
        $config = $this->getConfigFile("interfaces");
        if(isset($config['commands']))
        {
            foreach ($config['commands'] as $command)
            {
                $this->getServer()->getCommandMap()->register($command['fallbackPrefix'], new command\FormCommand($command['name'], $command['description'], $command['usage'], $command['sendForm']));
            }
        }
        FormManager::getInstance()->registerFormEvents($config);

        self::$main = $this;
        if (file_exists($this->getDataFolder() . "interfaces.yml"))
        {
            FormManager::getInstance()->registerForm($config);
        }else
        {
            $this->getConfig()->setAll(self::CONFIG);
            $this->getConfig()->save();
        }
    }

    /**
     * @param string $fileName
     * @param array $setting
     * @return Config
     */
    public function getConfigFile(string $fileName, array $setting = []): Config
    {
        return new Config($this->getDataFolder() . $fileName . ".yml", Config::YAML, $setting);
    }
}