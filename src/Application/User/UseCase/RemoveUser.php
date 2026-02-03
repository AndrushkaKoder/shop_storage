<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\User\Entity\User;
use App\Infrastructure\Doctrine\User\UserRepository;

final readonly class RemoveUser
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(User $user): int
    {
        return $this->userRepository->delete($user->getId());
    }
}
