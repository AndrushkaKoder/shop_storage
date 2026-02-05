<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;

final readonly class RemoveUser
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
