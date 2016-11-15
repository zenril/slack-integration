<?php
namespace AppBundle\Service;

use AppBundle\Entity\Person;
use AppBundle\Entity\PointHistory;
use AppBundle\Entity\SingleParam;
use AppBundle\Entity\DoubleParam;
use AppBundle\Entity\SlackDomain;


class SlackHelper
{
    public $container;
    public $body;
    public $em;

    public $personRepo;
    public $pointHistoryRepo;
    public $slackRepo;
    public $domainRepo;

    public $domain;
    public $sumbitter;
    public $last;

    public function __construct($container, $body) {
        $this->body = (object)$body;

        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->personRepo = $this->em->getRepository('AppBundle:Person');
        $this->pointHistoryRepo = $this->em->getRepository('AppBundle:PointHistory');  
        $this->domainRepo = $this->em->getRepository('AppBundle:SlackDomain');
        
        $this->domain = $this->domainRepo->findOneByDomain($this->body->team_domain);
        
        if(!$this->domain){
            $this->domain = new SlackDomain($this->body->team_domain);
            $this->em->persist($this->domain);
             $this->em->flush();             
        }

        $this->sumbitter = $this->personRepo->findOneBy(array('domain' => $this->domain, 'name' => $this->body->user_name ));
        if(!$this->sumbitter){
            $this->sumbitter = new Person($this->body->user_name);
            $this->sumbitter->setDomain($this->domain);
            $this->em->persist($this->sumbitter);
             $this->em->flush();
        }

        $this->last = $this->pointHistoryRepo->findOneBy(
            array('submitter'=>$this->sumbitter),
            array('created' => 'DESC')
        );

        $this->sumbitter = $this->personRepo->findOneBy(array('domain' => $this->domain, 'name' => $this->body->user_name ));

       
              
    }

    //  array(
    //      array("name" => "person",      "type" => "single", "match" => array("|@([^ @])|", 1) ),
    //      array("name" => "levelup", "key" => "lvl", "type" => "pair", "match" => array("|([-]*\d)|", 1) )
    //  )
    public function config($SubCommands){

    }

        public function parseLevels(){

        $plist = array();
        $response = array(
            "text" => "", 
            "response_type" => "in_channel",
            "attachments" => array()
        );  
        

        $plist[] = new SingleParam('/card', 'text', "|text:()|", function($param, $matches) use (&$response) {
           return intval($matches[1]);
        });

        $plist[] = new SingleParam('/card', 'bg', "|fg:((\d{0,3}),(\d{0,3}),(\d{0,3}))|", function($param, $matches) use (&$response) {
           return intval($matches[1]);
        });

        $plist[] = new SingleParam('/card', 'fg', "|fg:(\d{0,3},\d{0,3},\d{0,3}|", function($param, $matches) use (&$response) {
           return intval($matches[1]);
        });



        $this->parseParams($plist, function($result) use (&$response) { 

      
           if( isset($result["amount"]) && isset($result["people"])){
                foreach ($result["amount"] as $key => $amount) {
                    foreach ($result["people"] as $key => $person) {
                        if($person === $this->sumbitter){
                            continue;
                        }
                        $person->addScore($amount->getScore());
                        $person->setPointHistory($amount);
                    }
                }

                foreach ($result["people"] as $key => $person) {
                    $response["attachments"][] = array(
                        "text" => $person->getName() . " is on : ". $person->getScore()." points"
                    );
                }
           }

            if( isset($result["list"]) ) {
                $response["text"] = "All the points!";
                foreach ($result["list"][0] as $key => $person) {
                    $response["attachments"][] = array(
                        "text" => $person->getName() . " is on : ". $person->getScore()." points"
                    );
                }
            }            

            if( isset($result["help"]) ) {
                $response["text"] = "Heres some hints";
                $response["attachments"] = $result["help"][0];
            }        

            $this->em->flush();
            return $response;
        });

        return $response;
    }





    public function parseLevels(){

        $plist = array();
        $response = array(
            "text" => "", 
            "response_type" => "in_channel",
            "attachments" => array()
        ); 

        
        $plist[] = new SingleParam('/score', 'help', "|^help$|", function($param, $matches){
            
           
            return array(
               array( "text" => "/score @persons_name +1"),
                array( "text" => "/score list"),
                array( "text" => "/score help")
            );
            
        });


        $plist[] = new SingleParam('/score', 'list', "|^list$|", function($param, $matches){
            
            $people = $this->personRepo->findByDomain( $this->domain );        
            if(count($people) > 0){
                return $people;
            }
            return null;
            
        });

        $plist[] = new SingleParam('/score', 'people', "|@([^ @]*)|", function($param, $matches){

            $person = $this->personRepo->findOneBy(array('domain' => $this->domain, 'name' =>$matches[1] ));
            if(!$person){
                $person = new Person($matches[1]);
                $person->setDomain($this->domain);
                $this->em->persist($person);
            }
            return $person;
        });


        $plist[] = new SingleParam('/score', 'amount', "|\+{0,1}(\-{0,1}\d+)|", function($param, $matches) use (&$response) {

            
            $point = intval($matches[1]);
            if($point > -11 && $point < 11){

                if($point > 0){
                    $response["text"] = "What a good people!";
                }

                if($point < 0){
                    $response["text"] = "What a bad people!";
                }
                
                $pointHistory = new PointHistory();
                $pointHistory->setScore($point);
                $pointHistory->setSubmitter($this->sumbitter);
                $pointHistory->setDomain($this->domain);
                $pointHistory->setType("level");
                $this->em->persist($pointHistory);
                return $pointHistory;
            }

            $response["text"] = "Can only change points by max 10 at a time";
            return [];

            //$person;
        });


        $this->parseParams($plist, function($result) use (&$response) { 

      
           if( isset($result["amount"]) && isset($result["people"])){
                foreach ($result["amount"] as $key => $amount) {
                    foreach ($result["people"] as $key => $person) {
                        if($person === $this->sumbitter){
                            continue;
                        }
                        $person->addScore($amount->getScore());
                        $person->setPointHistory($amount);
                    }
                }

                foreach ($result["people"] as $key => $person) {
                    $response["attachments"][] = array(
                        "text" => $person->getName() . " is on : ". $person->getScore()." points"
                    );
                }
           }

            if( isset($result["list"]) ) {
                $response["text"] = "All the points!";
                foreach ($result["list"][0] as $key => $person) {
                    $response["attachments"][] = array(
                        "text" => $person->getName() . " is on : ". $person->getScore()." points"
                    );
                }
            }            

            if( isset($result["help"]) ) {
                $response["text"] = "Heres some hints";
                $response["attachments"] = $result["help"][0];
            }        

            $this->em->flush();
            return $response;
        });

        return $response;
    }


    private function parseParams($plist, $callback){
        $splitmessage = explode(" ", $this->body->text);
        $ret = array();
        
        foreach ($plist as $key => $p) {
            if(!isset($ret[$p->getName()])){
                //$ret[$p->getName()] = array();
            }
            if($p instanceof SingleParam){
            
                for ($i=0; $i < count( $splitmessage); $i++) { 
                    $item =  $splitmessage[$i];
                    
                    if( preg_match($p->getRegex(), $item, $matches) === 1 ){
                        $r = $p->trigger($p, $matches);
                        
                        if($r && !empty($r)){
                            $ret[$p->getName()][] = $r;
                        }
                    }
                }
                
            }

        }

        return $callback($ret);
    }
}