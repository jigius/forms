<?php

namespace jigius\forms\Field;

use jigius\forms\Form;
use jigius\forms\Exception\ParseException;

class FieldFactory
{
    public static function importInstance(array $data, Form $form)
    {
        if (!array_key_exists('type', $data)) {
            throw new ParseException("invalid field's data");
        }
        $className =  ucfirst(strtolower($type)) . 'Field';
        $field = static::createInstance($className, $form);
        $field->initialize($data);
        return $field;
    }

    public static function createInstance($className, Form $form)
    {
        $className = "jigius\\forms\\Field\\Type\\" . $className;
        $field = new $className($form);
        return $field;
    }
}
