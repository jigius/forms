<?php

namespace jigius\forms\Field\Type;

use jigius\forms\Field;

class NumberField extends Field
{
    public $type = 'Number';

    public function getInput()
    {
        return "<input />";
    }

    public function getLayout()
    {
        return "<p class={$this->type}>" . $this->getInput() .  "</p";
    }
}
