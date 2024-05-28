<?php

declare(strict_types=1);

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Article;
use App\Entity\Shop;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ArticlesTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetId()
    {
        $article = new Article();
        $this->assertNull($article->getId());
    }
    public function testGetReferenceArticle()
    {
        $article = new Article();
        $article->setReferenceArticle('article_reference');

        $this->assertSame('article_reference', $article->getReferenceArticle());
    }

    public function testSetReferenceArticle()
    {
        $article = new Article();
        $article->setReferenceArticle('article_reference');

        $this->assertSame('article_reference', $article->getReferenceArticle());
    }

    public function testGetPriceArticle()
    {
        $article = new Article();
        $article->setPriceArticle(10.99);

        $this->assertSame(10.99, $article->getPriceArticle());
    }

    public function testSetPriceArticle()
    {
        $article = new Article();
        $article->setPriceArticle(10.99);

        $this->assertSame(10.99, $article->getPriceArticle());
    }

    public function testGetQuantityArticle()
    {
        $article = new Article();
        $article->setQuantityArticle(5);

        $this->assertSame(5, $article->getQuantityArticle());
    }

    public function testSetQuantityArticle()
    {
        $article = new Article();
        $article->setQuantityArticle(5);

        $this->assertSame(5, $article->getQuantityArticle());
    }

    public function testGetShop()
    {
        $shop = new Shop();
        $article = new Article();
        $article->setShop($shop);

        $this->assertSame($shop, $article->getShop());
    }

    public function testSetShop()
    {
        $shop = new Shop();
        $article = new Article();
        $article->setShop($shop);

        $this->assertSame($shop, $article->getShop());
    }

    public function testGetLibelleArticle()
    {
        $article = new Article();
        $article->setLibelleArticle('Article 1');

        $this->assertSame('Article 1', $article->getLibelleArticle());
    }

    public function testSetLibelleArticle()
    {
        $article = new Article();
        $article->setLibelleArticle('Article 1');

        $this->assertSame('Article 1', $article->getLibelleArticle());
    }



}