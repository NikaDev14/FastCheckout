<?php

namespace App\DataFixtures;

use App\Entity\CartArticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ShopFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CartArticlesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cart_article = new CartArticle();
        $cart_article->setCart($this->getReference('cart'));
        $cart_article->setArticle($this->getReference('article.bis'));
        $cart_article->setNbItems(3);
        $manager->persist($cart_article);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CartFixtures::class,
            ArticleFixtures::class
        ];
    }

}