<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CartController;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\DeleteCartController;
use App\Controller\PostCartByCustomerIdController;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ApiResource(
   
    normalizationContext: ['groups' => [
        'read:carts:collection'
    ]],
    itemOperations: [
        'get',
        'put',
        'delete' => [
            'method' => 'DELETE',
            'path' => '/carts/{id}',
            'controller' => DeleteCartController::class,
            'write' => false
        ]
    ]
)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ApiProperty(readableLink: true, writableLink: true)]
    #[ORM\OneToMany(targetEntity: CartArticle::class, mappedBy: 'cart', cascade: ['remove'])]
    #[ORM\JoinTable(name: 'cart_articles')]
    #[Groups(['read:carts:collection'])]
    private $cartArticles;

    #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'cartsShop')]
    #[Groups(['read:carts:collection'])]
    private $shop;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:carts:collection'])]
    private $customerId;   

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:carts:collection'])]
    private $totalAmount;

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Groups(['read:carts:collection'])]
    private $isActive;

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Groups(['read:carts:collection'])]
    private $isValidate;

    public function __construct()
    {
        $this->cartArticles = new ArrayCollection();
        $this->isActive = true;
        $this->isValidate = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getCartArticles(): Collection
    {
        return $this->cartArticles;
    }
    
    public function addCartArticle(Article $article): self
    {
        if (!$this->cartArticles->contains($article)) {
            $this->cartArticles->add($article);
        }
        return $this;
    }

    public function removeCartArticle(Article $article): self
    {
        $this->cartArticles->removeElement($article);

        return $this;
    }
    /**
     * Add shop parent identifiers
     */
    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(?int $id): self
    {
        $this->customerId = $id;

        return $this;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }


    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }
    public function setTotalAmount(?float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsValidate(): ?bool
    {
        return $this->isValidate;
    }
    public function setIsValidate(?bool $isValidate): self
    {
        $this->isValidate = $isValidate;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
