<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\Cart;
use App\Entity\Article;
use App\Entity\CartArticle;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
class DeleteCartController extends AbstractController
{

    public function __construct(private ArticleRepository $articleRepository, private EntityManagerInterface $em)
    {

    }

    public function __invoke(Cart $data)
    {
        $cart_articles = $data->getCartArticles();
        foreach($cart_articles as $cart_article) {
            $found_article = $cart_article->getArticle();
            $article = $this->articleRepository->findOneBy([
                'referenceArticle' => $found_article->getReferenceArticle()
            ]);
            $article->setQuantityArticle($article->getQuantityArticle() + $cart_article->getNbItems());

            $this->em->persist($article);
            $this->em->remove($cart_article);
        }
        $this->em->remove($data);
        $this->em->flush();

        return;
    }

}
