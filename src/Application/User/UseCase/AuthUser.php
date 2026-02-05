<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\Exception\AuthException;
use App\Application\User\Service\AuthService;
use App\Domain\User\Repository\UserRepository;
use App\Infrastructure\Http\Api\User\v1\Auth\Input\AuthUserDto;

final readonly class AuthUser
{
    public function __construct(
        private UserRepository $userRepository,
        private AuthService $authService,

    ) {
    }

    /**
     * @param AuthUserDto $dto
     * @return string
     * @throws AuthException
     */
    public function handle(AuthUserDto $dto): string
    {
        $user = $this->userRepository->findByPhone($dto->phone);

        if (!$user) {
            throw new AuthException();
        }

        return $this->authService->attempt($user, $dto->password);
    }
}
