<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class HomeControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @test
     */
    public function testHomepageIsUp()
    {
        $this->client->request('GET', '/');
        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testAutocompleteArtistIsUp()
    {
        $this->client->request('GET', '/autocomplete/artist');
        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testAutocompleteArstistSendJSONArray(){
        $this->client->request('GET', '/autocomplete/artist');
        static::assertEquals(
            array(),
            json_decode ($this->client->getResponse()->getContent())
        );
    }
}
