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

    public function __construct($container, $body) {
        $this->body = (object)$body;

        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->personRepo = $this->em->getRepository('AppBundle:Person');
        $this->domainRepo = $this->em->getRepository('AppBundle:SlackDomain');
        
        $this->domain = $this->domainRepo->findOneByDomain($this->body->team_domain);
        
        if(!$this->domain){
            $this->domain = new SlackDomain($this->body->team_domain);
            $this->em->persist($this->domain);
                     
        }

        $this->sumbitter = $this->personRepo->findOneBy(array('domain' => $this->domain, 'name' => $this->body->user_name ));
        if(!$this->sumbitter){
            $this->sumbitter = new Person($this->body->user_name);
            $this->sumbitter->setDomain($this->domain);
            $this->em->persist($this->sumbitter);
        }
        $this->em->flush();
        $this->pointHistoryRepo = $this->em->getRepository('AppBundle:PointHistory');        
    }

    //  array(
    //      array("name" => "person",      "type" => "single", "match" => array("|@([^ @])|", 1) ),
    //      array("name" => "levelup", "key" => "lvl", "type" => "pair", "match" => array("|([-]*\d)|", 1) )
    //  )
    public function config($SubCommands){

    }

    public function parseLevels(){

        $plist = array();
        
        $plist[] = new SingleParam('/score', 'people', "|@([^ @]*)|", function($param, $matches){

            $person = $this->personRepo->findOneBy(array('domain' => $this->domain, 'name' =>$matches[1] ));
            if(!$person){
                $person = new Person($matches[1]);
                $person->setDomain($this->domain);
                $this->em->persist($person);
            }

            return $person;
        });


        $plist[] = new SingleParam('/score', 'amount', "|\+{0,1}(\-{0,1}\d+)|", function($param, $matches){

            
            $point = intval($matches[1]);
            
            $pointHistory = new PointHistory();
            $pointHistory->setScore($point);
            $pointHistory->setSubmitter($this->sumbitter);
            $pointHistory->setDomain($this->domain);
            $this->em->persist($pointHistory);

            return $pointHistory;//$person;
        });


        $this->parseParams($plist, function($result){
            foreach ($result["amount"] as $key => $amount) {
                foreach ($result["people"] as $key => $person) {
                    if($person === $this->sumbitter){
                        continue;
                    }
                   $person->addScore($amount->getScore());
                   $person->setPointHistory($amount);
                }
            }

            $this->em->flush();
            return $result["people"];
        });
    }


    private function parseParams($plist, $callback){
        $splitmessage = explode(" ", $this->body->text);
        $ret = array();
        
        foreach ($plist as $key => $p) {
            if(!isset($ret[$p->getName()])){
                $ret[$p->getName()] = array();
            }
            if($p instanceof SingleParam){
            
                for ($i=0; $i < count( $splitmessage); $i++) { 
                    $item =  $splitmessage[$i];
                    
                    if( preg_match($p->getRegex(), $item, $matches) === 1 ){
                        $ret[$p->getName()][] = $p->trigger($p, $matches);
                    }
                }
                
            }

        }

        return $callback($ret);
    }
}