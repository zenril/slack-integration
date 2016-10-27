<?php
namespace AppBundle\Service;

use AppBundle\Entity\Person;
use AppBundle\Entity\PointHistory;


class SlackHelper
{
    var $container;

    public function __construct($container) {
        $this->container = $container;
    }

    

}