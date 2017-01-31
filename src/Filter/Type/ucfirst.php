<?php

namespace jigius\form\Filter\Type;

class UcfirstFilter extends Filter
{
    protected $type = "ucfirst";

    public function pipe($value)
    {
        $fc = mb_strtoupper(mb_substr($value, 0, 1));
        return $fc.mb_substr($value, 1);
    }
}
