<?php
namespace jigius\form\Filter;

use jigius\registry\Registry;
use jigius\forms\Field\FieldInterface;

use jigius\forms\Exception\ParseException;

class FilterFactory
{
    public static function importInstance(array $data, FieldInterface $field)
    {
        if (!array_key_exists('type', $data)) {
            hrow new ParseException("invalid filter's data");
        }
        $className =  ucfirst(strtolower($type)) . 'Filter';
        $filter = static::createInstance($data['type'], $field);
        $filter->initialize($data);
        return $filter;
    }

    public static function createInstance($classname, FieldInterface $field)
    {
        $className = "jigius\\forms\\Filter\\Type\\" . $className;
        $field = new $className($field);
        return $field;
    }
}
