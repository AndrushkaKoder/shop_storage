<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Order\ValueObject\PaymentMethod;
use App\Domain\Order\ValueObject\Status;
use App\Domain\Product\Entity\Product;
use App\Domain\Shared\Entity\EntityInterface;
use App\Domain\User\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[HasLifecycleCallbacks]
#[ORM\Index(name: 'order_status_idx', columns: ['status'])]
class Order implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    public User $user;

    #[ORM\Column(type: 'float', nullable: false, options: ['unsigned' => true])]
    public float $totalSum = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: false, enumType: Status::class)]
    public Status $status;

    #[ORM\Column(type: 'string', length: 255, nullable: false, enumType: PaymentMethod::class)]
    public PaymentMethod $paymentMethod;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Product::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: '`order_product`')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    public Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->status = Status::NEW;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProducts(array $products): static
    {
        foreach ($products as $product) {
            $this->products->add($product);
        }

        return $this;
    }
}
