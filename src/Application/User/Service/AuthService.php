<?php

declare(strict_types=1);

namespace App\Application\User\Service;

use App\Application\Shared\Contract\TokenGenerator;
use App\Application\User\Exception\AuthException;
use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class AuthService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private TokenGenerator $tokenGenerator,
    ) {
    }

    /**
     * @throws AuthException
     */
    public function attempt(User $user, string $rawPassword): ?string
    {
        if ($this->passwordHasher->isPasswordValid($user, $rawPassword)) {
            return $this->tokenGenerator->generate($user);
        }

        throw new AuthException();
    }
}
