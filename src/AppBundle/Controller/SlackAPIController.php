<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// Post Route Definition
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;

use AppBundle\Entity\Person;
use AppBundle\Entity\PointHistory;
use AppBundle\Entity\SingleParam;
use AppBundle\Entity\DoubleParam;
use AppBundle\Service\SlackHelper;
use AppBundle\Service\ImageHelper;

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
        return    $sh->parseLevels();
    }

    /**
    * Get Route annotation.
    * 
    * 
    * @Get("/prof/{width}x{height}/{text}")
    */
    public function getImageAction(
    Request $request, 
    $width = 120, 
    $height = 120,
    $text = "a"
    )
    {  

        $colors = array(
            "bg" => array(255 ,255,255),
            "fg" => array(0,0,0)
        );

        // var_dump($request->get("bg"));
        // die();

        if($request->get("bg")){
            $rgb1 = explode("-", $request->get("bg"));
            $colors["bg"] = array(intval($rgb1[0]) % 256 ,intval($rgb1[1]) % 256,intval($rgb1[2]) % 256);
        }

        if($request->get("fg")){
            $rgb1 = explode("-", $request->get("fg"));
            $colors["fg"] = array(intval($rgb1[0]) % 256 ,intval($rgb1[1]) % 256,intval($rgb1[2]) % 256);
        }

     
        $image = imagecreate ( $width , $height );
        ImageHelper::triangles($image, $text, $colors);
        imagesavealpha($image,true);
        ob_start(); 
        imagepng($image);
        $str = ob_get_clean();
        return new Response($str, 200, array('Content-Type' => 'image/png'));

    }


    /** 
    * POST Route annotation.
    * @Get("/scores")
    */
    public function getScoreAction(Request $request)
    {

        $req = json_decode('{"token":"1Ixd1kzqNyzJf18wnm7pwimL","team_id":"T04UG2LA8","team_domain":"thehauntedrules","channel_id":"C09ND1TPS","channel_name":"test","user_id":"U04UHM2QJ","user_name":"eh-eh-ron-bot","command":"\/score","text":"help","response_url":"https:\/\/hooks.slack.com\/commands\/T04UG2LA8\/97867659921\/lYk6MTAYCBViZMiWwQbVBmoa"}');
        $sh = new SlackHelper($this->container, $req); 
        $people = $sh->parseLevels();

        return $people;
    }


    /** 
    * POST Route annotation.
    * @Get("/test")
    */
    public function gettestAction(Request $request)
    {

  

        return array(20,50) == array(50,20);
    }


}
