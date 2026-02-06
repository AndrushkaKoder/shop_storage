<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Category\Entity\Category;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Entity\EntityInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '`product`')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'products_active_idx', columns: ['is_active'])]
class Product implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    public string $name;

    #[ORM\Column(type: 'float', nullable: false)]
    public float $price;

    #[ORM\Column(type: 'float', nullable: true)]
    public ?float $discount = null;

    #[ORM\Column(type: 'json', nullable: true)]
    public ?array $images = null;

    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: false)]
    public bool $is_active = true;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'products')]
    public Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): static
    {
        $this->updatedAt = new DateTimeImmutable();

        return $this;
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

    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }


    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);

            $category->addProduct($this);
        }

        return $this;
    }

    public function getCategories(): ?Collection
    {
        return $this->categories;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
        return $this;
    }

    public function getTotalPrice(): float
    {
        $price = $this->getPrice();
        $discount = $this->getDiscount();

        return ($discount && $discount < $price) ? $discount + $price : $price;
    }
}
