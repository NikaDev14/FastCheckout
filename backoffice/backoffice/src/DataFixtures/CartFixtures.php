<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cart = new Cart();
        $cart->setShop($this->getReference('shop.bis'));
        $cart->setCustomerId($this->getReference('user.bis')->getId());
        $this->addReference('cart', $cart);
        $manager->persist($cart);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            UserFixtures::class
        ];
    }
}
