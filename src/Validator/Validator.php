<?php

namespace jigius\forms\Validator;

use jigius\registry\Registry;
use jigius\forms\Utils;
use jigius\forms\Form;

abstract class Validator implements ValidatorInterface
{
    protected $field;

    protected $xData;

    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
        $this->xData = new Registry();
    }

    public function initialize(array $data)
    {
        foreach ($data as $k => $v) {
            Utils::feedRegistry($this->xData, $k, $v);
        }
    }
}
