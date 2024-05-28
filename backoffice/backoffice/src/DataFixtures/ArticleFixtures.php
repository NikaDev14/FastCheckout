<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ShopFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /* Commented these fixtures since some pertinent data are needed for the POC's presentation
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setReferenceArticle($i.'3456789');
            $article->setLibelleArticle('Haribo'.$i);
            $article->setPriceArticle($i + 1);
            $article->setQuantityArticle(3);
            $article->setShop($this->getReference('shop.bis'));
            $manager->persist($article);
        }
        $manager->persist($this->getReference('shop.bis'));
        */
        $manager->persist($this->getReference('shop.bis'));
        $manager->persist($this->getReference('shop.bis0'));

        $article = new Article();
        $article->setReferenceArticle('0012345678901');
        $article->setLibelleArticle('Haribo CrocoPik');
        $article->setPhotoArticle('harribo-crocopik.png');
        $article->setPriceArticle(1.6);
        $article->setQuantityArticle(20);
        $article->setShop($this->getReference('shop.bis'));
        $manager->persist($article);

        $article_2 = new Article();
        $article_2->setReferenceArticle('0012345678902');
        $article_2->setLibelleArticle('Haribo Schtroumpfs');
        $article_2->setPhotoArticle('harribo-schtroumfs.jpg');
        $article_2->setPriceArticle(1.2);
        $article_2->setQuantityArticle(15);
        $article_2->setShop($this->getReference('shop.bis'));
        $manager->persist($article_2);

        $article_3 = new Article();
        $article_3->setReferenceArticle('0012345678903');
        $article_3->setLibelleArticle('Haribo Dragibus');
        $article_3->setPhotoArticle('harribo-dragibus.jpg');
        $article_3->setPriceArticle(0.9);
        $article_3->setQuantityArticle(15);
        $article_3->setShop($this->getReference('shop.bis'));
        $manager->persist($article_3);

        $article_4 = new Article();
        $article_4->setReferenceArticle('0012345678904');
        $article_4->setLibelleArticle('Kinder Pingui');
        $article_4->setPhotoArticle('kinder-pingui.jpg');
        $article_4->setPriceArticle(1.8);
        $article_4->setQuantityArticle(12);
        $article_4->setShop($this->getReference('shop.bis'));
        $manager->persist($article_4);

        $article_5 = new Article();
        $article_5->setReferenceArticle('0012345678905');
        $article_5->setLibelleArticle('Kinder Bueno');
        $article_5->setPhotoArticle('kinder-bueno.jpg');
        $article_5->setPriceArticle(2.2);
        $article_5->setQuantityArticle(30);
        $article_5->setShop($this->getReference('shop.bis'));
        $manager->persist($article_5);

        $article_6 = new Article();
        $article_6->setReferenceArticle('0012345678906');
        $article_6->setLibelleArticle('Kinder Délice');
        $article_6->setPhotoArticle('kinder-delice.jpg');
        $article_6->setPriceArticle(1.3);
        $article_6->setQuantityArticle(27);
        $article_6->setShop($this->getReference('shop.bis'));
        $manager->persist($article_6);

        $article_7 = new Article();
        $article_7->setReferenceArticle('0012345678907');
        $article_7->setLibelleArticle('Kinder Surprise');
        $article_7->setPhotoArticle('kinder-surprise.jpg');
        $article_7->setPriceArticle(0.7);
        $article_7->setQuantityArticle(23);
        $article_7->setShop($this->getReference('shop.bis'));
        $manager->persist($article_7);

        $article_8 = new Article();
        $article_8->setReferenceArticle('0012345678908');
        $article_8->setLibelleArticle('Kinder Country');
        $article_8->setPhotoArticle('kinder-country.jpg');
        $article_8->setPriceArticle(1.2);
        $article_8->setQuantityArticle(9);
        $article_8->setShop($this->getReference('shop.bis'));
        $manager->persist($article_8);

        $article_9 = new Article();
        $article_9->setReferenceArticle('0012345678909');
        $article_9->setLibelleArticle('Cristaline 50cl');
        $article_9->setPhotoArticle('cristaline-50cl.jpg');
        $article_9->setPriceArticle(0.2);
        $article_9->setQuantityArticle(12);
        $article_9->setShop($this->getReference('shop.bis'));
        $manager->persist($article_9);

        $article_10 = new Article();
        $article_10->setReferenceArticle('00123456789010');
        $article_10->setLibelleArticle('Daunat - Poulet Mayonnaise');
        $article_10->setPhotoArticle('daunat-poulet-mayo.jpg');
        $article_10->setPriceArticle(2.1);
        $article_10->setQuantityArticle(12);
        $article_10->setShop($this->getReference('shop.bis'));
        $manager->persist($article_10);

        $article_11 = new Article();
        $article_11->setReferenceArticle('0012345678911');
        $article_11->setLibelleArticle('Daunat - Thon Oeufs');
        $article_11->setPhotoArticle('daunat-thon-oeuf.jpg');
        $article_11->setPriceArticle(1.95);
        $article_11->setQuantityArticle(12);
        $article_11->setShop($this->getReference('shop.bis'));
        $manager->persist($article_11);

        $article_12 = new Article();
        $article_12->setReferenceArticle('0012345678912');
        $article_12->setLibelleArticle('Pain suédois - Saumon');
        $article_12->setPhotoArticle('pain-suedois-saumon.jpg');
        $article_12->setPriceArticle(2.3);
        $article_12->setQuantityArticle(12);
        $article_12->setShop($this->getReference('shop.bis'));
        $manager->persist($article_12);

        $article_13 = new Article();
        $article_13->setReferenceArticle('0012345678913');
        $article_13->setLibelleArticle('Coca Cola 33cl');
        $article_13->setPhotoArticle('coca-cola-50cl.jpg');
        $article_13->setPriceArticle(1);
        $article_13->setQuantityArticle(12);
        $article_13->setShop($this->getReference('shop.bis'));
        $manager->persist($article_13);

        $article_14 = new Article();
        $article_14->setReferenceArticle('0012345678914');
        $article_14->setLibelleArticle('Perrier 33cl');
        $article_14->setPhotoArticle('perrier.jpg');
        $article_14->setPriceArticle(1.1);
        $article_14->setQuantityArticle(12);
        $article_14->setShop($this->getReference('shop.bis'));
        $manager->persist($article_14);

        $article_to_ref = new Article();
        $article_to_ref->setReferenceArticle('0012345678915');
        $article_to_ref->setLibelleArticle('Carambar');
        $article_to_ref->setPhotoArticle('carambar.jpg');
        $article_to_ref->setPriceArticle(0.6);
        $article_to_ref->setQuantityArticle(8);
        $article_to_ref->setShop($this->getReference('shop.bis'));
        $this->addReference('article.bis', $article_to_ref);
        $manager->persist($article_to_ref);

        $article_to_shop0 = new Article();
        $article_to_shop0->setReferenceArticle('0012345678916');
        $article_to_shop0->setLibelleArticle('Fanta');
        $article_to_shop0->setPhotoArticle('fanta.jpg');
        $article_to_shop0->setPriceArticle(1.6);
        $article_to_shop0->setQuantityArticle(35);
        $article_to_shop0->setShop($this->getReference('shop.bis0'));
        $manager->persist($article_to_shop0);

        $manager->flush();
        
    }

    public function getDependencies()
    {
        return [
            ShopFixtures::class,
        ];
    }
    
}
