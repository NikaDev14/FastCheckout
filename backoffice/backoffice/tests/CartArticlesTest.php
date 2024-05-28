<?php

namespace App\Tests\Entity;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use App\Entity\Article;
use App\Entity\CartArticle;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class CartArticlesTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetId()
    {
        $cartArticle = new CartArticle();
        $this->assertNull($cartArticle->getId());
    }

    public function testGetCart()
    {
        $cart = new Cart();
        $cartArticle = new CartArticle();
        $cartArticle->setCart($cart);

        $this->assertSame($cart, $cartArticle->getCart());
    }

    public function testSetCart()
    {
        $cart = new Cart();
        $cartArticle = new CartArticle();
        $cartArticle->setCart($cart);

        $this->assertSame($cart, $cartArticle->getCart());
    }

    public function testGetArticle()
    {
        $article = new Article();
        $cartArticle = new CartArticle();
        $cartArticle->setArticle($article);

        $this->assertSame($article, $cartArticle->getArticle());
    }

    public function testSetArticle()
    {
        $article = new Article();
        $cartArticle = new CartArticle();
        $cartArticle->setArticle($article);

        $this->assertSame($article, $cartArticle->getArticle());
    }

    public function testGetNbItems()
    {
        $cartArticle = new CartArticle();
        $cartArticle->setNbItems(3);

        $this->assertSame(3, $cartArticle->getNbItems());
    }

    public function testSetNbItems()
    {
        $cartArticle = new CartArticle();
        $cartArticle->setNbItems(3);

        $this->assertSame(3, $cartArticle->getNbItems());
    }

    public function testToString()
    {
        $cartArticle = new CartArticle();
        $article = new Article();
        $article->setLibelleArticle('Article 1');
        $cartArticle->setArticle($article);
        $cartArticle->setNbItems(2);

        $this->assertSame('Nom : Article 1 Nombre : 2', $cartArticle->__toString());
    }
}