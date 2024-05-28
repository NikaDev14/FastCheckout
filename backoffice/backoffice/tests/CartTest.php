<?php

namespace App\Tests\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Shop;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class CartTest extends ApiTestCase
{
    use RefreshDatabaseTrait;
    public function testGetId()
    {
        $cart = new Cart();
        $this->assertNull($cart->getId());
    }

    public function testGetCartArticles()
    {
        $cart = new Cart();
        $this->assertEmpty($cart->getCartArticles());
    }

    public function testAddCartArticle()
    {
        $cart = new Cart();
        $article = new Article();
        $this->assertInstanceOf(Cart::class, $cart->addCartArticle($article));
    }

    public function testRemoveCartArticle()
    {
        $cart = new Cart();
        $article = new Article();
        $this->assertInstanceOf(Cart::class, $cart->removeCartArticle($article));
    }

    public function testGetShop()
    {
        $cart = new Cart();
        $this->assertNull($cart->getShop());
    }

    public function testSetShop()
    {
        $cart = new Cart();
        $shop = new Shop();
        $this->assertInstanceOf(Cart::class, $cart->setShop($shop));
    }

    public function testGetUser()
    {
        $cart = new Cart();
        $this->assertNull($cart->getUser());
    }

    public function testSetUser()
    {
        $cart = new Cart();
        $user = new User();
        $this->assertInstanceOf(Cart::class, $cart->setUser($user));
    }

    public function testGetTotalAmount()
    {
        $cart = new Cart();
        $this->assertNull($cart->getTotalAmount());
    }

    public function testSetTotalAmount()
    {
        $cart = new Cart();
        $this->assertInstanceOf(Cart::class, $cart->setTotalAmount(120));
    }

    public function testGetIsActive()
    {
        $cart = new Cart();
        $this->assertNull($cart->getIsActive());
    }

    public function testSetIsActive()
    {
        $cart = new Cart();
        $this->assertInstanceOf(Cart::class, $cart->setIsActive(true));
    }

    public function testGetIsValidate()
    {
        $cart = new Cart();
        $this->assertNull($cart->getIsValidate());
    }

    public function testSetIsValidate()
    {
        $cart = new Cart();
        $this->assertInstanceOf(Cart::class, $cart->setIsValidate(true));
    }
}
