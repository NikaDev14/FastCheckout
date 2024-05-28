<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Shop;
use Doctrine\Common\Collections\ArrayCollection;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;


class ShopsTest extends ApiTestCase
{
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetNameShop(): void
    {
        $shop = new Shop();
        $shop->setNameShop('Test shop');

        $this->assertSame('Test shop', $shop->getNameShop());
    }

    public function testSetNameShop(): void
    {
        $shop = new Shop();
        $shop->setNameShop('Test shop');

        $this->assertSame($shop, $shop->setNameShop('New name'));
        $this->assertSame('New name', $shop->getNameShop());
    }

    public function testGetReferenceShop(): void
    {
        $shop = new Shop();
        $shop->setReferenceShop('test_reference');

        $this->assertSame('test_reference', $shop->getReferenceShop());
    }

    public function testSetReferenceShop(): void
    {
        $shop = new Shop();
        $shop->setReferenceShop('test_reference');

        $this->assertSame($shop, $shop->setReferenceShop('new_reference'));
        $this->assertSame('new_reference', $shop->getReferenceShop());
    }

    public function testGetArticlesShop()
    {
        $shop = new Shop();
        $article1 = new Article();
        $article1->setLibelleArticle('Article 1');
        $article2 = new Article();
        $article2->setLibelleArticle('Article 2');
        $shop->addArticlesShop($article1);
        $shop->addArticlesShop($article2);

        $articles = $shop->getArticlesShop();
        $this->assertInstanceOf(ArrayCollection::class, $articles);
        $this->assertCount(2, $articles);

        $expectedTitles = ['Article 1', 'Article 2'];
        foreach ($articles as $article) {
            $this->assertInstanceOf(Article::class, $article);
            $this->assertContains($article->getLibelleArticle(), $expectedTitles);
        }
    }

    public function testAddArticlesShop(): void
    {
        $shop = new Shop();
        $article = new Article();
        $article->setLibelleArticle('test article');

        $this->assertSame($shop, $shop->addArticlesShop($article));
        $this->assertCount(1, $shop->getArticlesShop());
        $this->assertTrue($shop->getArticlesShop()->contains($article));
        $this->assertSame($shop, $article->getShop());
    }

    public function testRemoveArticlesShop(): void
    {
        $shop = new Shop();
        $article = new Article();
        $article->setLibelleArticle('test article');
        $shop->addArticlesShop($article);

        $this->assertSame($shop, $shop->removeArticlesShop($article));
        $this->assertCount(0, $shop->getArticlesShop());
        $this->assertFalse($shop->getArticlesShop()->contains($article));
        $this->assertNull($article->getShop());
    }

    public function testAddCartsShop(): void
    {
        $shop = new Shop();
        $cart = new Cart();

        $this->assertSame($shop, $shop->addCartsShop($cart));
        $this->assertCount(1, $shop->getCartsShop());
        $this->assertTrue($shop->getCartsShop()->contains($cart));
        $this->assertSame($shop, $cart->getShop());
    }

    public function testGetCartsShop()
    {
        $shop = new Shop();
        $cart1 = new Cart();
        $cart2 = new Cart();
        $shop->addCartsShop($cart1);
        $shop->addCartsShop($cart2);

        $carts = $shop->getCartsShop();
        $this->assertInstanceOf(ArrayCollection::class, $carts);
        $this->assertCount(2, $carts);

        foreach ($carts as $cart) {
            $this->assertInstanceOf(Cart::class, $cart);
        }
    }

    public function testValidShop(): void
    {
        $shop = new Shop();
        $shop->setNameShop('Ma Boutique');
        $shop->setReferenceShop('123456');

        $this->assertEquals('Ma Boutique', $shop->getNameShop());
        $this->assertEquals('123456', $shop->getReferenceShop());
    }

    public function testInvalidShop(): void
    {
        $shop = new Shop();
        $shop->setNameShop('');
        $shop->setReferenceShop('');

        $this->assertNotEmpty($shop->getNameShop());
        $this->assertNotEmpty($shop->getReferenceShop());
    }

    public function testAddArticleToShop(): void
    {
        $shop = new Shop();
        $article = new Article();
        $article->setLibelleArticle('Product 1');

        $shop->addArticlesShop($article);

        $this->assertCount(1, $shop->getArticlesShop());
        $this->assertEquals($shop, $article->getShop());
    }

    public function testRemoveArticleFromShop(): void
    {
        $shop = new Shop();
        $article = new Article();
        $article->setLibelleArticle('Product 1');

        $shop->addArticlesShop($article);
        $shop->removeArticlesShop($article);

        $this->assertCount(0, $shop->getArticlesShop());
        $this->assertNull($article->getShop());
    }

}
