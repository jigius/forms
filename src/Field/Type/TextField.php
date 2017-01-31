<?php

namespace jigius\forms\Field\Type;

use jigius\forms\Field;

class TextField extends Field
{
    public $type = 'text';

    public function getInput()
    {
        return "<input />";
    }

    public function getLayout()
    {
        return "<p class={$this->type}>" . $this->getInput() .  "</p";
    }
}
