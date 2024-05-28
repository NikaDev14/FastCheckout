<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ShopsApiTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testGetShops()
    {
        $this->client->request('GET', 'api/shops');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetShop()
    {
        $referenceShop = '0123330';

        $this->client->request('GET', '/api/shops/' . $referenceShop);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCreateShop()
    {
        $data = [
            'nameShop' => 'Shop Test',
            'referenceShop' => '0123456'
        ];

        $this->client->request('POST', '/api/shops', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateShop()
    {
        $referenceShop = '0123456';
        $data = [
            'nameShop' => 'Shop Test Updated',
        ];

        $this->client->request('PUT', '/api/shops/' . $referenceShop, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}