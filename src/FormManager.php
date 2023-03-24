<?php

namespace SixpennyYard\EasyInterface;

use pocketmine\form\Form;
use pocketmine\utils\Config;
use SixpennyYard\EasyInterface\exception\FormName;
use SixpennyYard\EasyInterface\form\NewCustomForm;
use SixpennyYard\EasyInterface\form\NewModalForm;
use SixpennyYard\EasyInterface\form\NewSimpleForm;

class FormManager{

    protected NewModalForm $modalFormManage;
    protected NewCustomForm $customFormManage;
    protected NewSimpleForm $simpleFormManage;
    protected static FormManager $formManager;

    public static function getInstance(): FormManager
    {
        return self::$formManager;
    }
    public function registerForm (Config $config): void
    {
        $total = count((array)$config['interfaces']);
        $value = 1;
        foreach ($config['interfaces'] as $data)
        {
            $percent = ($value/$total)*100;
            if (strtolower($data['type']) == "simple")
            {
                $form = new NewSimpleForm($data['title'], $data['content'], $data['button']);
            }elseif (strtolower($data['type']) == "custom")
            {
                //TODO: CustomForm
            }elseif (strtolower($data['type']) == "modal")
            {
                //TODO: ModalForm
            }
            Main::getInstance()->getLogger()->info("Interface call: " . $data['title'] . " is now registered ! " . $percent . "% is registered.");
            $value += 1;
        }
    }

    /**
     * @throws FormName
     */
    public function getFormByTitle(string $formTitle): Form
    {
        if (isset($this->simpleFormManage->simpleForm[$formTitle]))
        {
            return $this->simpleFormManage->simpleForm[$formTitle];
        }elseif (isset($this->customFormManage->customForm[$formTitle]))
        {
            return $this->customFormManage->customForm[$formTitle];
        }elseif (isset($this->modalFormManage->modalForm[$formTitle]))
        {
            return $this->modalFormManage->modalForm[$formTitle];
        }
        return throw new FormName("Please use a correct form name. You can correct that in the configuration file: interfaces.yml. \n$formTitle's incorrect !");
    }

}