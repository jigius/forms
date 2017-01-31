<?php
namespace jigius\forms;

use jigius\registry\Registry;

class Utils
{
    public static function feedRegistry(Registry $registry, $prop, $data)
    {
        if (is_array($data)) {
            $new = new Registry();
            foreach ($data as $k => $v) {
                $new->set($k, $v);
            }
        } else {
            $new = $data;
        }
        $registry->set($prop, $new);
    }
}
