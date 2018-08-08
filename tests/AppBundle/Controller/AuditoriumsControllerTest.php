<?php
/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 19.06.2018
 * Time: 23:15
 */

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class AuditoriumsControllerTest extends TestCase
{
    const BASE_URL = 'http://localhost:8000';
    const AUDITORIUM_ID = 1;

    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testGetAuditoriumsAction()
    {
        $response = $this->client->get(self::BASE_URL.'/auditoriums');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetAuditoriumAction()
    {
        $response = $this->client->get(self::BASE_URL.'/auditoriums/'.self::AUDITORIUM_ID);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
