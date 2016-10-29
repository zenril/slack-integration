<?php

namespace AppBundle\Entity;


class DoubleParam extends SingleParam 
{

    private $key;
    
    public function __construct( $command, $key, $name, $regex, $callback)
    {
        $this->command = $command;
        $this->name = $name;
        $this->regex = $regex;
        $this->callback = $callback;
        $this->key = $key;
        $this->type = "double";
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $key;
    }

    public function getKey()
    {
        return $this->key;
    }
}

