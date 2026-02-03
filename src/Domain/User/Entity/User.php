<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\Entity\EntityInterface;
use App\Domain\User\ValueObject\UserRole;
use App\Infrastructure\Doctrine\User\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'user_phone_idx', columns: ['phone'])]
class User implements EntityInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public int $id;

    #[ORM\Column(name: 'first_name', type: 'string', length: 255, nullable: false)]
    public string $firstName;

    #[ORM\Column(name: 'last_name', type: 'string', length: 255, nullable: false)]
    public string $lastName;

    #[ORM\Column(name: 'phone', type: 'string', length: 10, unique: true, nullable: false)]
    public string $phone;

    #[ORM\Column(name: 'password', type: 'string', length: 255, nullable: false)]
    public string $password;

    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: false)]
    public bool $isActive = true;

    #[ORM\Column(name: 'roles', type: 'json', nullable: false)]
    public array $roles = [];

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    public DateTimeImmutable $createdAt;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = UserRole::ROLE_USER->value;

        return array_unique($roles);
    }

    public function setRoles(array $roles = []): static
    {
        $this->roles = count($roles) ? $roles : $this->getRoles();

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

    public function getUserIdentifier(): string
    {
        return $this->phone;
    }
}
