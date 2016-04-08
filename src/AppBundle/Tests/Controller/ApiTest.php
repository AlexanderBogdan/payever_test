<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testAlbums()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/albums');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // @todo check application/json header

        $response = json_decode($client->getResponse()->getContent());
        // @todo check response to contain "data"
        // @todo check data to contain all album properties
        // @todo check album to contain <= 10 images


    }
}
