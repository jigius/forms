<?php
if(!defined('e3Entry') || !e3Entry) die('Invalid Entry Point');

require_once __DIR__ . "/../validator.php";
require_once __DIR__ . "/../../c.registry.php";

class StringFormValidator extends CFormValidator
{
    public function test($value)
    {
        return CValidatorString::_($value, $this->parseOptions()->getArray());
    }

    public function getError()
    {
        return CValidatorString::getError();
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
                case 'minlen':
                case 'maxlen':
                    if (preg_match('/\D/', $itr->current())){
                        // DEBUG invalid param
                    }
                    else{
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
        if (($min = $res->get('minlen', 0)) < 0){
            // DEBUG - minlen - invalid!
            $res->remove('minlen');
        }

        if ($max = $res->get('maxlen', 0) < 0 || $min > $max){
            // DEBUG - maxlen - invalid!
            $res->remove('maxlen');
        }

        return $res;
    }
}

//---
