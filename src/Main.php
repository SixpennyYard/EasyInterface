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
            ]
        ];
    private static Main $main;
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
        self::$main = $this;
        if (file_exists($this->getDataFolder() . "interfaces.yml"))
        {
            $config = $this->getConfigFile("interfaces");
            FormManager::getInstance()->registerForm($config);
        }else
        {
            $this->getConfig()->setAll(self::CONFIG);
            $this->getConfig()->save();
        }
    }

    public function getConfigFile(string $fileName, array $setting = []): Config
    {
        return new Config($this->getDataFolder() . $fileName . ".yml", Config::YAML, $setting);
    }
}