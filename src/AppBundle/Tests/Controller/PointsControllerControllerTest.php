<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PointsControllerControllerTest extends WebTestCase
{
    public function testSlack()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/slack');
    }

}
