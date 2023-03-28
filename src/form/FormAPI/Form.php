<?php

declare(strict_types = 1);

namespace SixpennyYard\EasyInterface\form\FormAPI;

use pocketmine\form\Form as IForm;
use pocketmine\player\Player;

abstract class Form implements IForm{

    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var callable|null
     */
    private $callable;

    /**
     * @param callable|null $callable
     */
    public function __construct(?callable $callable) {
        $this->callable = $callable;
    }

    /**
     * @return callable|null
     */
    public function getCallable() : ?callable {
        return $this->callable;
    }

    /**
     * @param callable|null $callable
     */
    public function setCallable(?callable $callable) {
        $this->callable = $callable;
    }

    /**
     * @param Player $player
     * @param $data
     * @return void
     */
    public function handleResponse(Player $player, $data) : void {
        $this->processData($data);
        $callable = $this->getCallable();
        if($callable !== null) {
            $callable($player, $data);
        }
    }

    /**
     * @param $data
     * @return void
     */
    public function processData(&$data) : void {
    }

    /**
     * @return array
     */
    public function jsonSerialize(){
        return $this->data;
    }
}