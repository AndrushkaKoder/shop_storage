<?php

declare(strict_types=1);

namespace App\Domain\Cart\Entity;

use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Entity\Product;
use App\Domain\Shared\Entity\EntityInterface;
use App\Domain\User\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[Table(name: '`cart`')]
#[HasLifecycleCallbacks]
class Cart implements EntityInterface
{
    #[Id]
    #[GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'cart')]
    public User $user;

    #[ORM\Column(name: 'total', type: 'float', nullable: false, options: ['unsigned' => true])]
    public float $totalSum = 0;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Product::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: '`cart_product`')]
    #[ORM\JoinColumn(name: 'cart_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    public Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTotalSum(): float
    {
        return $this->totalSum;
    }

    public function setTotalSum(float $totalSum): static
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): static
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): static
    {
        $this->updatedAt = new DateTimeImmutable();

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $this->setTotalSum($this->getTotalSum() + $product->getPrice());
        }
        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(
        Product $product
    ): static {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }
}
