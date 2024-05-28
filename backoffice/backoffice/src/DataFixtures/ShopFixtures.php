<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $shop = new Shop();
            $shop->setNameShop('shopName '.$i);
            $shop->setReferenceShop('012333'.$i);
            $shop->setPhotoShop('shop.jpg');
            $shop->setAddress($i. ' Rue du Pont');
            $shop->setCity('Paris');
            $shop->setZipCode('75001');
            $shop->setPhoneNumber('010000000'.$i);
            $this->addReference('shop.bis' .$i, $shop);

            $manager->persist($shop);
        }
        $shop_bis = new Shop();
        $shop_bis->setNameShop('Carrefour');
        $shop_bis->setReferenceShop('9932828');
        $shop_bis->setPhotoShop('carrefour.jpg');
        $shop_bis->setAddress('7 Rue du Pont');
        $shop_bis->setCity('Paris');
        $shop_bis->setZipCode('75001');
        $shop_bis->setPhoneNumber('0100000001');
        $this->addReference('shop.bis', $shop_bis);

        $manager->flush();
    }
}
