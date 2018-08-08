<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class MoviesControllerTest extends TestCase
{
    const BASE_URL = 'http://localhost:8000';
    const MOVIE_ID = 1;

    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testGetMoviesAction()
    {
        $response = $this->client->get(self::BASE_URL.'/movies');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetMovieAction()
    {
        $response = $this->client->get(self::BASE_URL.'/movies/'.self::MOVIE_ID);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
