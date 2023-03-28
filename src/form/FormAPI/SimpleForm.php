<?php

declare(strict_types = 1);

namespace SixpennyYard\EasyInterface\form\FormAPI;

class SimpleForm extends Form {

    const IMAGE_TYPE_PATH = 0;
    const IMAGE_TYPE_URL = 1;

    /**
     * @var string
     */
    private $content = "";
    /**
     * @var array
     */
    private $labelMap = [];

    /**
     * @param callable|null $callable
     */
    public function __construct(?callable $callable) {
        parent::__construct($callable);
        $this->data["type"] = "form";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
        $this->data["buttons"] = [];
    }

    /**
     * @param $data
     * @return void
     */
    public function processData(&$data) : void {
        $data = $this->labelMap[$data] ?? null;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title) : void {
        $this->data["title"] = $title;
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->data["title"];
    }

    /**
     * @return string
     */
    public function getContent() : string {
        return $this->data["content"];
    }

    /**
     * @param string $content
     * @return void
     */
    public function setContent(string $content) : void {
        $this->data["content"] = $content;
    }

    /**
     * @param string $text
     * @param int $imageType
     * @param string $imagePath
     * @param string|null $label
     * @return void
     */
    public function addButton(string $text, int $imageType = -1, string $imagePath = "", ?string $label = null) : void {
        $content = ["text" => $text];
        if($imageType !== -1) {
            $content["image"]["type"] = $imageType === 0 ? "path" : "url";
            $content["image"]["data"] = $imagePath;
        }
        $this->data["buttons"][] = $content;
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

}