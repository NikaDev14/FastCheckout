<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Valid;
use App\Controller\PostCartAmountController;
use App\Controller\DeleteCartArticleController;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => [
        'read:carts:collection'
    ]],
    denormalizationContext: ['groups' => [
        'write:CartArticle'
    ]],
    itemOperations: [
        'get',
        'delete'=> [
            'method' => 'DELETE',
            'path' => '/cart_articles/{id}',
            'controller' => DeleteCartArticleController::class,
            'write' => false
        ]
    ],
    collectionOperations: [
        'get',
        'post'=> [
            'method' => 'POST',
            'path' => '/cart_articles',
            'controller' => PostCartAmountController::class
        ]
    ],
    )]
#[ORM\Table(name: 'cart_articles')]
class CartArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartArticles' )]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write:CartArticle'])]
    private $cart;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write:CartArticle', 'read:carts:collection'])]
    private $article;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Groups(['write:CartArticle','read:carts:collection'])]
    private $nbItems;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getNbItems(): ?int
    {
        return $this->nbItems;
    }

    public function setNbItems(int $nbItems): self
    {
        $this->nbItems = $nbItems;

        return $this;
    }

    public function __toString(): string
    {
        return 'Nom : '. $this->getArticle().' Nombre : '.$this->getNbItems();
    }
}