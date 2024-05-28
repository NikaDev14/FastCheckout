<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartArticlesApiTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testGetCartArticles()
    {

        $this->client->request('GET', '/api/cart_articles');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetCartArticle()
    {
        $cartArticleId = '9';

        $this->client->request('GET', '/api/cart_articles/' . $cartArticleId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testPostCartArticle()
    {
        $data = [
            'cart' => '/api/carts/9',
            'article' => '/api/articles/0012345678901',
            'nbItems' => 1
        ];

        $this->client->request('POST', '/api/cart_articles', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteCartArticle()
    {

        $this->client->request('DELETE', '/api/cart_articles/10');

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
}