<?php

namespace SixpennyYard\EasyInterface\form;

use SixpennyYard\EasyInterface\form\FormAPI\ModalForm;

class NewModalForm
{

    public ModalForm $modalForm;

    public function __construct(string $title, string $content = null, $button = null, string $image = null)
    {
        $this->NewModalForm($title, $content, $button, $image);
    }

    private function NewModalForm(string $title, ?string $content, mixed $button, ?string $image): void
    {
    }
}