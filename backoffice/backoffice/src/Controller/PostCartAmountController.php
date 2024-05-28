<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\Cart;
use App\Entity\CartArticle;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
class PostCartAmountController extends AbstractController
{

    public function __construct(private ArticleRepository $articleRepository, private CartRepository $cartRepository, private EntityManagerInterface $em)
    {

    }
    public function __invoke(CartArticle $data, Request $request): Cart
    {
        $req_article = $request->get('article');
        $parser = explode("/", $req_article);
        $reference_article = $parser[3];
        $article = $this->articleRepository->findOneBy([
            'referenceArticle' => $reference_article
        ]);
        $data->setArticle($article);

        $req_cart = $request->get('cart');
        $parser = explode("/", $req_cart);
        $id_cart = $parser[3];
        $cart = $this->cartRepository->findOneBy([
            'id' => $id_cart
        ]);

        $data->setCart($cart);
        $data->setNbItems(1);
        $this->em->persist($data);
        $this->em->flush();

        $cart->setIsActive(true);
        $cart->setIsValidate(false);

        $article->setQuantityArticle($article->getQuantityArticle() - $data->getNbItems());

        $retrieved_cart_articles = $cart->getCartArticles();
        $full_amount = 0;
        foreach($retrieved_cart_articles as $retrieved_cart_article) {
            $full_amount += ($retrieved_cart_article->getArticle()->getPriceArticle())*($retrieved_cart_article->getNbItems());
        }
        $cart->setTotalAmount($full_amount);

        return $cart;
    }

}
