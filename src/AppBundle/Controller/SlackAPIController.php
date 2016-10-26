<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// Post Route Definition
use FOS\RestBundle\Controller\Annotations\Post;

class SlackAPIController extends Controller
{
   
   /**
    * POST Route annotation.
    * @Post("/score/add")
    */
    public function postScoreAction()
    {

        
        return null;
    }

}
