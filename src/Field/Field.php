<?php

namespace jigius\forms;

use jigius\registry\Registry;
use jigius\forms\Utils;
use jigius\forms\Entry;
use jigius\forms\Form;

use jigius\forms\Exception\ParseException;
use jigius\forms\Exception\InvalidDataException;
use jigius\forms\Exception\EnvironmentException;

abstract class Field implements FieldInterface
{
    protected $isFed, $isInvalid, $invalidMsgs, $form, $filters, $validators, $value, $xData;

    public function __construct(Form $form) {
        $this->isFed = false;
        $this->isInvalid = null;
        $this->invalidMsgs = [];
        $this->form = $form;

        $this->value = null;
        $this->filters = [];
        $this->validators = [];
        $this->xData = new Registry();
        $this->xData->set('default', null);
    }

    public function isFed()
    {
        return $this->isFed;
    }

    public function isInvalid()
    {
        return $this->isInvalid;
    }

    public function initialize(array $data)
    {
        foreach ($data as $k => $v) {
            switch ($k) {
                case 'processes':
                    $this->processesLoad($v, ['filters', 'validators']);
                    break;

                default:
                    Utils::feedRegistry($this->xData, $k, $v);
            }
        }
    }

    protected function processesLoad(array $data, array $entities)
    {
        foreach ($data as $context => $cdata){
            if (!in_array($context, ['model', 'user-data']))     {
                throw new ParseException("unknown context='{$context}'");
            }

            if (empty($cdata)) {
                continue;
            }
            if (!is_array($cdata)) {
                throw new ParseException("context='{$context}' data is not array");
            }

            foreach ($cdata as $dir => $ddata) {
                if (!in_array($dir, ['in', 'out'])) {
                    throw new ParseException("unknown direction='{$dir}'");
                }

                if (empty($ddata)) {
                    continue;
                }
                foreach ($ddata as $k => $v) {

                    if (!in_array($k, $entities)) {
                        throw new ParseException("unknown entities='{$k}' for context='{$context}', direction='{$dir}'");
                    }
                    if (empty($v)) {
                        continue;
                    }
                    if (!is_array($v)) {
                        throw new ParseException("entities='{$k}' data is not array: context='{$context}', direction='{$direction}'");
                    }

                    $this->processesEntitiesLoad($context, $dir, $k, $v);
                }
            }
        }
    }

    protected static function createHashDouble($one, $two)
    {
        return $one . "@" . $two;
    }

    protected static function checkExistsOrCreate(array $target, $key)
    {
        if (!array_key_exists($key, $target)) {
            $target[$key] = [];
        }
    }

    protected function processesEntitiesLoad($context, $direction, $entities, $data)
    {
        foreach ($data as $v) {
            if (empty($v)) {
                continue;
            }
            if (!is_array($v)) {
                throw new ParseException("entities='{$entities}': entity data is not array: context='{$context}', direction='{$direction}'");
            }
            $hash = static::createHashDouble($context, $direction);


            if ($entities == "filters") {
                $factory = Entry::getInstance()->getFilterFactory();
                $target = $this->filters;
            } else {
                $factory = Entry::getInstance()->getValidatorFactory();
                $target = $this->validators;
            }
            $target[$hash][] = $factory::importInstance($v, $this);
        }
    }


    protected function getKeyByContext($context)
    {
        if ($context === 'model') {
            if (!$this->xData->isExists($context . "-key")) {
                $context = 'user-data';
            }
        }

        if (!$this->xData->isExists($context . "-key")) {
            throw new EnvironmentException("there is no '{$context}-key' definition");
        }
        return $this->xData->get($context . "-key");
    }

    public function feed($context, CRegistry $input)
    {
        $key = $this->getKeyByContext($context);
        $value = $input->get($key);
        $this->setValue($context, $value);
        $this->isFed = true;
    }

    public function setValue($context, $value)
    {
        $v = $this->valueRaw = $value;

        $hash = static::createHashDouble($context, 'in');
        if (array_key_exists($hash, $this->filters)) {
            foreach ($this->filters[$hash] as $filter) {
                try {
                    $v = $filter->pipe($v);
                } catch (InvalidDataException $e) {
                    $this->isInvalid = true;
                    $this->invalidMsgs[] = $filter->getError();
                    break;
                }
            }
        }
        $this->value = $v;
        return $this;
    }

    public function clear()
    {
        $this->isInvalid = null;
        $this->invalidMsgs = [];
        $this->isFed = false;
        $this->valueRaw = $this->value = null;
    }

    protected function getInvalidMsgs()
    {
        return $this->invalidMsgs;
    }

    public function getValue($context)
    {

    }

    abstract public function getInput();

    abstract public function getLayout();
}
