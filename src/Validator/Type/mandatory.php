<?php
if(!defined('e3Entry') || !e3Entry) die('Invalid Entry Point');

require_once __DIR__ . "/../validator.php";
require_once __DIR__ . "/../../c.registry.php";

class MandatoryFormValidator extends CFormValidator
{
    public function test($value)
    {
        return CValidatorMandatory::_($value, $this->parseOptions()->getArray());
    }

    public function getError()
    {
        return CValidatorMandatory::getError();
    }

    public function getInfo()
    {
        return "-";
    }

    protected function parseOptions()
    {
        $res = new CRegistry();
        $opts = $this->xData->get('options', null);

        if ($opts === null || !is_object($opts) || !in_array('IRegistry', class_implements($opts))) {
            // DEBUG options is empty!
            return $res;
        }
        $itr = $opts->getIterator();
        while($itr->valid()){
            switch($itr->key()){
                case 'trigger':
                    $res->set($itr->key(), (boolean)$itr->current());
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
        return $res;
    }
}

//---
