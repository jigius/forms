<?php

namespace jigius\form\Filter\Type;

class StrtolowerFilter extends Filter
{
    protected $type = "strtolower";

    public function pipe($value)
    {
        return mb_strtolower($value);
    }
}
