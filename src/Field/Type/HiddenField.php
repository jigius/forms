<?php

namespace jigius\forms\Field\Type;

use jigius\forms\Field;

class HiddenField extends Field
{
    public $type = 'hidden';

    public function getInput()
    {
        return "<input />";
    }

    public function getLayout()
    {
        return "<p class={$this->type}>" . $this->getInput() .  "</p";
    }
}
