<?php

namespace jigius\form\Filter\Type;

class UrldecodeFilter extends Filter
{
    protected $type = "urldecode";

    public function pipe($value)
    {
        return urldecode($value);
    }
}
