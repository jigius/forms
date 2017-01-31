<?php

namespace jigius\forms;

interface FactoryInterface
{
    public static function getField();

    public static function getFilter();

    public static function getValidator();
}
