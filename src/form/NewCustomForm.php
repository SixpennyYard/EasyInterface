<?php

namespace SixpennyYard\EasyInterface\form;

use pocketmine\player\Player;
use SixpennyYard\EasyInterface\form\FormAPI\CustomForm;

class NewCustomForm
{

    public CustomForm $customForm;

    public function __construct(string $title, $dropdown = null, $stepSlider = null, $slider = null, $toggle = null, $label = null, $input = null)
    {
        $this->NewCustomForm($title, $dropdown, $stepSlider, $slider, $toggle, $label, $input);
    }

    private function NewCustomForm(string $title, mixed $dropdown, mixed $stepSlider, mixed $slider, mixed $toggle, mixed $label, mixed $input): void
    {
        //TODO: NewCustomForm
        $form = new CustomForm(function (Player $player, ?array $data)
        {
            if ($data === null) return true;
            //ici je switch mes elements
        });


        $form->setTitle($title);
        if (!$dropdown === null)
        {
            foreach ($dropdown as $drop)
            {
                $array = [];
                foreach ($drop[1] as $item)
                {
                    $array = $item;
                }
                $form->addDropdown($drop[0], $array);
            }
        }
        if (!$stepSlider === null)
        {
            foreach ($stepSlider as $step)
            {
                $array = [];
                foreach ($stepSlider[1] as $item)
                {
                    $array = $item;
                }
                $form->addStepSlider($stepSlider[0], $array);
            }
        }
        if (!$slider === null)
        {
            $form->addSlider($slider[0], $slider[1], $slider[2]);
        }
        if (!$toggle === null)
        {
            if ($toggle[1] === true or $toggle[1] === false)
            {
                if (isset($toggle[2]))
                {
                    $form->addToggle($toggle[0], $toggle[1], $toggle[2]);
                }
                else
                {
                    $form->addToggle($toggle[0], $toggle[1]);
                }
            }
            else
            {
                if (isset($toggle[1]))
                {
                    $form->addToggle($toggle[0], false, $toggle[1]);
                }
                else
                {
                    $form->addToggle($toggle[0], false);
                }
            }

        }
        if (!$label === null)
        {
            $form->addLabel($label[0]);
        }
        if (!$input === null)
        {
            if (isset($input[1]))
            {
                $form->addInput($input[0], $input[1]);
            }
            else
            {
                $form->addInput($input[0]);
            }
        }
    }

}