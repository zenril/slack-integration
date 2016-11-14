<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FontsController extends Controller
{
    /**
     * @Route("/add/font")
     */
    public function addFontAction()
    {   
        $return = array();
        $dir = __DIR__ . "/../Resources/public/fonts/*";
        foreach(glob($dir) as $file)
        {
             $return[] = array( 
                 "fileName" => basename($file),
                 "fontName" => substr(basename($file),0,-4)
             );
        }

        return $this->render('AppBundle:Fonts:add_font.html.twig', array(
            "fonts" => $return,
        ));
    }
}
 