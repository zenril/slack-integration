<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
// Post Route Definition
use FOS\RestBundle\Controller\Annotations\Post;

use AppBundle\Entity\Person;
use AppBundle\Entity\PointHistory;

class SlackAPIController extends Controller
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
}
