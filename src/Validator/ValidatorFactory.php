<?php

namespace jigius\forms;

use jigius\forms\Field\FieldInterface;

class ValidatorFactory
{
    public static function importInstance(array $data, FieldInterface $field)
    {
        if (!array_key_exists('type', $data)) {
            throw new ParseException("invalid validator's data");
        }
        $className =  ucfirst(strtolower($type)) . 'Validator';
        $validator = static::createInstance($className, $field);
        $validator->initialize($data);

        return $validator;
    }

    public static function createInstance($type, FieldInterface $field)
    {
        $className = "jigius\\forms\\Validator\\Type\\" . $className;
        $field = new $className($form);

        return $field;
    }
}
