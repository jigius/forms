<?php

namespace jigius\form\Filter;

interface FilterInterface
{
    public function pipe($value);
    public function getError();
}
