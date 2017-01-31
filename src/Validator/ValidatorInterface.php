<?php

namespace jigius\forms\Validator;

interface ValidatorInterface
{
    public function test($value);

    public function getError();

    public function getInfo();
}
