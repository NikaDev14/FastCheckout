<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiProperty;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['read:shop:collection']
    ],
    denormalizationContext: [
        'groups' => ['write:Shop']
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:shop:collection', 'read:shop:item','read:Article']],
            'path' => '/shops/{referenceShop}',
            ['method' => 'get']
        ],
        'put' => [
            'denormalization_context' => ['groups' => ['put:Article']]
        ]
        ],
        collectionOperations: [
            'get',
            'post'
        ]
)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ApiProperty(identifier: false)]
    #[Groups(['read:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private $nameShop;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[ApiProperty(identifier: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private $referenceShop;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: Article::class, cascade: ['persist'])]
    #[
        Groups(['read:shop:collection', 'write:Shop', 'read:carts:collection'])
    ]
    #[ApiSubresource]
    private $articlesShop;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: Cart::class)]
    private $cartsShop;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: User::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[
        Groups(['read:Article','put:Article', 'read:shop:collection', 'read:shop:item', 'write:Shop'])
    ]
    private $photoShop;

    public function __construct()
    {
        $this->articlesShop = new ArrayCollection();
        $this->cartsShop = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameShop(): ?string
    {
        return $this->nameShop;
    }

    public function setNameShop(string $nameShop): self
    {
        $this->nameShop = $nameShop;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticlesShop(): Collection
    {
        return $this->articlesShop;
    }

    public function addArticlesShop(Article $articlesShop): self
    {
        if (!$this->articlesShop->contains($articlesShop)) {
            $this->articlesShop[] = $articlesShop;
            $articlesShop->setShop($this);
        }

        return $this;
    }

    public function removeArticlesShop(Article $articlesShop): self
    {
        if ($this->articlesShop->removeElement($articlesShop)) {
            // set the owning side to null (unless already changed)
            if ($articlesShop->getShop() === $this) {
                $articlesShop->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCartsShop(): Collection
    {
        return $this->cartsShop;
    }

    public function addCartsShop(Cart $cartsShop): self
    {
        if (!$this->cartsShop->contains($cartsShop)) {
            $this->cartsShop[] = $cartsShop;
            $cartsShop->setShop($this);
        }

        return $this;
    }

    public function removeCartsShop(Cart $cartsShop): self
    {
        if ($this->cartsShop->removeElement($cartsShop)) {
            // set the owning side to null (unless already changed)
            if ($cartsShop->getShop() === $this) {
                $cartsShop->setShop(null);
            }
        }

        return $this;
    }

    public function getReferenceShop(): string
    {
        return $this->referenceShop;
    }

    public function setReferenceShop(string $referenceShop): self
    {
        $this->referenceShop = $referenceShop;
        return $this;
    }

    public function __toString()
    {
        return $this->nameShop;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setShop($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getShop() === $this) {
                $user->setShop(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhotoShop(): ?string
    {
        return $this->photoShop;
    }

    public function setPhotoShop(?string $photoShop): ?self
    {
        $this->photoShop = $photoShop;

        return $this;
    }
}
