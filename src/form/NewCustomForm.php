<?php

namespace SixpennyYard\EasyInterface\form;

use SixpennyYard\EasyInterface\form\FormAPI\CustomForm;

class NewCustomForm
{

    public CustomForm $customForm;

    public function __construct(string $title, string $content = null, $button = null, string $image = null)
    {
        $this->NewCustomForm($title, $content, $button, $image);
    }

    private function NewCustomForm(string $title, ?string $content, mixed $button, ?string $image): void
    {
    }
}