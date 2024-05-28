<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\CartArticle;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
class DeleteCartArticleController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em)
    {

    }
    public function __invoke(CartArticle $data)
    {

        $stored_article = $data->getArticle();
        $cart = $data->getCart();
        $stored_article->setQuantityArticle($stored_article->getQuantityArticle() + $data->getNbItems());
        // here we should handle the totalAmount price
        $updatedTotalAmount = $cart->setTotalAmount($cart->getTotalAmount() - $stored_article->getPriceArticle());
        $this->em->persist($stored_article);
        $this->em->persist($updatedTotalAmount);
        $this->em->remove($data);
        $this->em->flush();

        return;
    }

}
