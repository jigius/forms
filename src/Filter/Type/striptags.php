<?php

namespace jigius\form\Filter\Type;

use jigius\registry\Registry;
use jigius\registry\RegistryInterface;

class StriptagsFilter extends Filter
{
    protected $type = "striptags";

    public function pipe($value)
    {
        $o = $this->parseOptions($this->xData->get('options', null));
        if ($o->isExists('allowable_tags')) {
            $res = strip_tags($value, $o->get('allowable_tags'));
        } else {
            $res = strip_tags($value);
        }
        return $res;
    }

    protected function parseOptions(RegistryInterface $opts = null)
    {
        $res = new Registry();
        if ($opts === null) {
            return $res;
        }

        $itr = $opts->getIterator();
        while ($itr->valid()) {
            switch ($itr->key()) {
                case 'allowable_tags':
                    $res->set($itr->key(), $itr->current());
                    break;

                default:
                    // DEBUG - unknown param!
            }
            $itr->next();
        }
        return $res;
    }
}
