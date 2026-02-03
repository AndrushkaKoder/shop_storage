<?php

declare(strict_types=1);

namespace App\Infrastructure\Resource\User\v1;

use App\Domain\User\Entity\User;
use App\Infrastructure\Contract\ResourceInterface;

final readonly class UserResource implements ResourceInterface
{
    public function __construct(private User $user)
    {
    }

    public function present(): array
    {
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getFirstName() . ' ' . $this->user->getLastName(),
            'phone' => $this->user->getPhone(),
            'isActive' => $this->user->getIsActive(),
            'roles' => $this->user->getRoles(),
            'createdAt' => $this->user->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }
}
