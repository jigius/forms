<?php

namespace jigius\forms;

use jigius\forms\Factory;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerInterface\NullLogger;

class Entry
{
    protected static $instance;

    protected $factory;

    protected $logger;

    protected function __construct()
    {
        $this->factory = $this->setFactory();
        $this->logger = null;
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setFactory(FactoryInterface $factory = null)
    {
        if ($this->factory === null) {
            $this->$factory = new Factory();
        } else {
            $this->factory = $factory;
        }
        return $this;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
