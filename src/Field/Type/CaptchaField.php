<?php

namespace jigius\forms\Field\Type;

use jigius\forms\Field;

class CaptchaField extends CFormField
{
    public $type = 'captcha';

    public function getInput()
    {
        return "<input />";
    }

    public function getLayout()
    {
        return "<p class={$this->type}>" . $this->getInput() .  "</p";
    }
}
