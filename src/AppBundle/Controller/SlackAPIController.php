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
       
        
        return   $data;    
    }


    /**
    * POST Route annotation.
    * @Get("/scores")
    */
    public function getScoreAction(Request $request)
    {
        return array("a");
    }


}
