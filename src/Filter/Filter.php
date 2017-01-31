<?php

namespace jigius\form\Filter;

use jigius\form\Utils;
use jigius\registry\Registry;
use jigius\form\Field\FieldInterface;

abstract class Filter implements FilterInterface
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

    public function getError()
    {
        return "Invalid format of input data";
    }
}
