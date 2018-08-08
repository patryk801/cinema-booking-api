<?php
/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 20.06.2018
 * Time: 21:58
 */

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;

class ReservationsControllerTest extends TestCase
{
    const BASE_URL = 'http://localhost:8000';
    const RESERVATION_ID = 10;

    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testGetReservationsAction()
    {
        $response = $this->client->get(self::BASE_URL.'/reservations');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetReservationAction()
    {
        $response = $this->client->get(self::BASE_URL.'/reservations/'.self::RESERVATION_ID);

        $this->assertEquals(200, $response->getStatusCode());
    }
}