<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Auth;

use App\Application\User\UseCase\AuthUser;
use App\Infrastructure\Http\Api\User\v1\Auth\Input\AuthUserDto;

final readonly class Manager
{
    public function __construct(
        private AuthUser $useCase
    )
    {
    }

    public function handle(AuthUserDto $dto): string
    {
        return $this->useCase->handle($dto);
    }
}
