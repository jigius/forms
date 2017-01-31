<?php

namespace jigius\form;

use jigius\registry\Registry;
use jigius\forms\Utils;
use jigius\forms\Entry;

use jigius\forms\Exception\ParseException;
use jigius\forms\Exception\EnvironmentException;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException as YamlParseException;

class Form
{
    protected $isLoaded;

    protected $fields;

    protected $isFed;

    protected $xData;

    public function __construct()
    {
        $this->isLoaded = false;
        $this->isFed = false;
        $this->fields = [];
        $this->xData = new Registry();
    }

    public function load($file)
    {
        try {
            $fdata = Yaml::parse(file_get_contents($file));
        } catch (YamlParseException $e) {
            throw new ParseException($e->getMessage());
        }

        foreach ($fdata as $k => $v) {
            switch ($k) {

                case 'fields':
                    $this->fieldsLoad($v);
                    break;

                default:
                    Utils::feedRegistry($this->xData, $k, $v);
            }
        }
        $this->isLoaded = true;
    }

    public function isLoaded()
    {
        return $this->isLoaded;
    }

    protected function fieldsLoad(array $data){
        $factory = Entry::getFieldFactory();
        foreach ($data as $k => $v) {
            $this->fields[] = $factory::importInstance($v, $this);
        }
    }

    public function feed($context, Registry $data)
    {
        if (!$this->isLoaded()) {
            throw new EnvironmentException("form is not loaded");
        }

        foreach ($this->fields as $field) {
            $field->feed($context, $data);
        }
        $this->isFed = true;
    }

    public function isFed()
    {
        return $this->isFed;
    }

    public function validate($context)
    {
        if (!$this->isLoaded()) {
            throw new EnvironmentException("form is not loaded");
        }

        foreach ($this->fields as $field) {
            $field->validate($context);
        }
    }
}
