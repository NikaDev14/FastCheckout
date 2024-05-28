<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ArticlesApiTest extends WebTestCase
{
    private $client;
    private $articleRepository;


    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->articleRepository = static::getContainer()->get(ArticleRepository::class);
    }

    public function testGetArticles()
    {
        $this->client->request('GET', 'api/articles');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetArticle()
    {
        $articleShop = '0012345678901';

        $this->client->request('GET', '/api/articles/' . $articleShop);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetShopArticle()
    {
        $referenceShop = '9932828';

        $this->client->request('GET', '/api/shops/' . $referenceShop . '/articles_shops');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCreateValidArticle()
    {

        $data = [
            'referenceArticle' => 'ART001',
            'libelleArticle' => 'Article 1',
            'priceArticle' => 10.0,
            'quantityArticle' => 5,
            'shop' => '/api/shops/0123330'
        ];
        $headers = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ];
        $this->client->request('POST', '/api/articles', [], [], $headers, json_encode($data));

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testUpdateValidArticle()
    {
        $referenceArticle = 'ART001';
        $newPrice = 9.99;

        $this->client->request(
            'PUT',
            '/api/articles/' . $referenceArticle,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'priceArticle' => $newPrice
            ])
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // Verify that the article was actually updated in the database
        $updatedArticle = $this->articleRepository->findOneBy(['referenceArticle' => $referenceArticle]);
        $this->assertEquals($newPrice, $updatedArticle->getPriceArticle());
    }

    public function testDeleteArticle()
    {
        $referenceArticle = 'ART001';

        // Delete the article
        $this->client->request(
            'DELETE',
            '/api/articles/' . $referenceArticle
        );

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());

        // Verify that the article was actually deleted from the database
        $deletedArticle = $this->articleRepository->findOneBy(['referenceArticle' => $referenceArticle]);
        $this->assertNull($deletedArticle);
    }

    public function testCreateInvalidArticle()
    {
        $this->client->request(
            'POST',
            '/api/articles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'referenceArticle' => '',
                'libelleArticle' => 'Short name',
                'priceArticle' => 1.23,
                'quantityArticle' => 0
            ])
        );

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());

        // Verify that the article was not actually created in the database
        $createdArticle = $this->articleRepository->findOneBy(['referenceArticle' => '']);
        $this->assertNull($createdArticle);
    }
}