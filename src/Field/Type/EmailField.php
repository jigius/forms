<?php

namespace jigius\forms\Field\Type;

use jigius\forms\Field;

class EmailField extends Field
{
    public $type = 'email';

    public function getInput()
    {
        return "<input />";
    }

    public function getLayout()
    {
        return "<p class={$this->type}>" . $this->getInput() .  "</p";
    }
}
