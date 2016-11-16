<?php

namespace AppBundle\Entity;


class SingleParam
{

    private $name;
    private $type;
    private $regex;
    private $command;
    private $callback;

    public function __construct( $command, $name, $regex, $callback)
    {
        $this->command = $command;
        $this->name = $name;
        $this->regex = $regex;
        $this->callback = $callback;
        $this->type = "single";
    }
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    public function getRegex()
    {
        return $this->regex;
    }

    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function trigger($param = null, $matches = array())
    {
        $callback = $this->getCallback();
        return $callback($param, $matches );
    }
}

