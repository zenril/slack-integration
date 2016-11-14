<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FontsControllerTest extends WebTestCase
{
    public function testAddfont()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add/font');
    }

}
