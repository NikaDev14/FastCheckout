<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    attributes : [
        'validation_groups' => []
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:collection', 'read:item', 'read:Article']],
            'path' => '/articles/{referenceArticle}',
            ['method' => 'get']
        ],
        'put'=> [
            'denormalization_context' => ['groups' => ['put:Article']],
            'validation_groups' => [
                'create:Article'
            ]
        ],
        'delete'
    ],
    collectionOperations: [
        'get',
        'post' => [
            'validation_groups' => [
                Article::class, 'validationGroups'
            ]
        ]
    ],
    normalizationContext: [
        'groups' => ['read:collection', 'read:shop:collection', 'read:carts:collection']
    ]
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ApiProperty(identifier: false)]
    #[Groups(['read:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[ApiProperty(identifier: true)]
    #[
        Groups(['read:collection', 'put:Article', 'read:shop:collection', 'read:carts:collection']),
        Length(min : 5, groups: ['create:Article'])
    ]
    private $referenceArticle;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collection', 'put:Article', 'read:shop:collection', 'read:carts:collection'])]
    private $libelleArticle;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:collection', 'put:Article', 'read:shop:collection', 'read:carts:collection'])]
    private $priceArticle;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collection', 'put:Article', 'read:shop:collection', 'read:carts:collection'])]
    private $quantityArticle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:collection', 'put:Article', 'read:shop:collection', 'read:carts:collection'])]
    private $photoArticle;

    #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'articlesShop' )]
    #[
        Groups(['put:Article'])
    ]
    #[ORM\JoinColumn(nullable: false)]
    private $shop;


    public static function validationGroups(self $article)
    {
        return ['create:Article'];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceArticle(): ?string
    {
        return $this->referenceArticle;
    }

    public function setReferenceArticle(string $referenceArticle): self
    {
        $this->referenceArticle = $referenceArticle;

        return $this;
    }

    public function getPriceArticle(): ?float
    {
        return $this->priceArticle;
    }

    public function setPriceArticle(float $priceArticle): self
    {
        $this->priceArticle = $priceArticle;

        return $this;
    }

    public function getQuantityArticle(): ?int
    {
        return $this->quantityArticle;
    }

    public function setQuantityArticle(int $quantityArticle): self
    {
        $this->quantityArticle = $quantityArticle;

        return $this;
    }
    
    #[Groups(['read:item'])]
    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getLibelleArticle(): string
    {
        return $this->libelleArticle;
    }

    public function setLibelleArticle(string $libelleArticle): self
    {
        $this->libelleArticle = $libelleArticle;

        return $this;
    }

    public function getPhotoArticle(): ?string
    {
        return $this->photoArticle;
    }

    public function setPhotoArticle(?string $photoArticle): ?self
    {
        $this->photoArticle = $photoArticle;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getLibelleArticle();
    }
}
