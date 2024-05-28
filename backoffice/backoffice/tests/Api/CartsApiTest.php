<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartsApiTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testGetCarts(): void
    {
        $this->client->request('GET', '/api/carts');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetCart()
    {
        $cartId = '9';

        $this->client->request('GET', '/api/carts/' . $cartId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCreateCart(): void
    {
        $data = [
            'isActive' => true,
            'isValidate' => false,
        ];

        $this->client->request('POST', '/api/carts', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateCart(): void
    {
        $data = [
            'isActive' => false,
            'isValidate' => true,
        ];

        $this->client->request('PUT', '/api/carts/10', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteCart(): void
    {

        $this->client->request('DELETE', '/api/carts/10');

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
}