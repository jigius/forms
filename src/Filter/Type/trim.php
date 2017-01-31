<?php

namespace jigius\form\Filter\Type;

use jigius\registry\Registry;
use jigius\registry\RegistryInterface;

class TrimFilter extends Filter
{
    protected $type = "trim";

    public function pipe($value)
    {
        $o = $this->parseOptions($this->xData->get('options', null));
        if ($o->isExists('character_mask')) {
            $res = trim($value, $o->get('character_mask'));
        } else {
            $res = trim($value);
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
                case 'character_mask':
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
