<?php
if(!defined('e3Entry') || !e3Entry) die('Invalid Entry Point');

require_once __DIR__ . "/../validator.php";
require_once __DIR__ . "/../../c.registry.php";

class IntegerFormValidator extends CFormValidator
{
    public function test($value){
        return CValidatorInteger::_($value, $this->parseOptions()->getArray());
    }

    public function getError()
    {
        return CValidatorInteger::getError();
    }

    public function getInfo()
    {
        return "-";
    }

    protected function parseOptions()
    {
        $res = new CRegistry();
        if (!property_exists('options', $this)) {
            // DEBUG options is empty!
            return $res;
        }
        if (!in_array('CRegistry', class_implements($this->options))) {
            // DEBUG options' type is invalid
            return $res;
        }
        $itr = $this->options->getIterator();
        while ($itr->valid()) {
            switch ($itr->key()) {
                case 'min':
                case 'max':
                    if (preg_match('/\D/', $itr->current())) {
                        // DEBUG invalid param
                    } else {
                        $res->set($itr->key(), (int)$itr->current());
                    }
                    break;

                case 'error':
                    $res->set($itr->key(), (string)$itr->current());
                    break;

                case 'info':
                    $res->set($itr->key(), (string)$itr->current());
                    break;

                default:
                    // DEBUG - unknown param!
            }
            $itr->next();
        }
        if (($min = $res->get('min', 0)) < 0) {
            // DEBUG - min - invalid!
            $res->remove('min');
        }

        if ($max = $res->get('max', 0) < 0 || $min > $max) {
            // DEBUG - max - invalid!
            $res->remove('max');
        }

        return $res;
    }
}

//---
