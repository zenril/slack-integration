<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
// Post Route Definition
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;

use AppBundle\Entity\Person;
use AppBundle\Entity\PointHistory;
use AppBundle\Entity\SingleParam;
use AppBundle\Entity\DoubleParam;
use AppBundle\Service\SlackHelper;

class SlackAPIController extends FOSRestController
{
   
   /**
    * POST Route annotation.
    * @Post("/score/add")
    */
    public function postScoreAction(Request $request)
    {
        $request->getContent();
        $data = $request->request->all();

        $sh = new SlackHelper($this->container, $data); 
        $people = $sh->parseLevels();
        return array(
            "text" => "asdasdasdads", 
            "response_type" => "in_channel",
            "attachments" => array(
                "text" => "Partly cloudy today and tomorrow"
            )
        );    
    }

    /**
    * POST Route annotation.
    * @Get("/scores")
    */
    public function getPersonalImage(Request $request)
    {

        // header ( 'Content-Type: image/jpeg' );
        // $image = imagecreatefromjpeg("../Resources/public/images/test.jpg");
        // imagejpeg($image);
    }


    /**
    * POST Route annotation.
    * @Get("/scores")
    */
    public function getScoreAction(Request $request)
    {

        $req = json_decode('{"token":"1Ixd1kzqNyzJf18wnm7pwimL","team_id":"T04UG2LA8","team_domain":"thehauntedrules","channel_id":"C09ND1TPS","channel_name":"test","user_id":"U04UHM2QJ","user_name":"eh-eh-ron-bot","command":"\/score","text":"@slackbot @eh-eh-ron-bot +5","response_url":"https:\/\/hooks.slack.com\/commands\/T04UG2LA8\/97867659921\/lYk6MTAYCBViZMiWwQbVBmoa"}');
        $sh = new SlackHelper($this->container, $req); 
        $people = $sh->parseLevels();

        return "yay";
    }


}
