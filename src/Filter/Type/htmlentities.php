<?php

namespace jigius\form\Filter\Type;

class HtmlentitiesFilter extends Filter{
    protected $type = 'htmlentities';

    public function pipe($value)
    {
        return htmlentities($value);
    }
}
