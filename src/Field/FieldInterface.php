<?php

namespace jigius\forms\Field;

interface FieldInterface
{
    //public function value($new = null, $setFilters = null);
    public function getInput();
    public function getLayout();
}
