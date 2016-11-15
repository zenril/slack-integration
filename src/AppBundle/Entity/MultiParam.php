<?php

namespace AppBundle\Entity;

//new MultiParam()

class MultiParam extends SingleParam 
{

    private $key;
    private $results;
    
    public function __construct( $command, $key, $name, $regex, $callback)
    {
        $this->command = $command;
        $this->name = $name;
        $this->regex = $regex;
        $this->callback = $callback;
        $this->key = $key;
        $this->type = "multi";
        $this->results = array();
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $key;
    }

    public function addResult($key)
    {
        $this->results[] = $key;
    }

    public function getResults()
    {
        return $this->results;
    }


    public function getKey()
    {
        return $this->key;
    }

    public function parseSlackParams($slack_response){
    
    }

    public static function parse($slack_response, $multiParams = array()){
        foreach ($multiParams as $paramKey => $param) {
            
            foreach ($param->regex as $key => $value) {
                preg_match_all($value, $slack_response["text"], $out, PREG_SET_ORDER);
                $param->addResult($out);
            }
            $param->trigger($param, $param->getResults());
        }       
    }
    
}

