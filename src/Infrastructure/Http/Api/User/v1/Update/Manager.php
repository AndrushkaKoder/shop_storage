<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Update;

use App\Application\User\UseCase\UpdateUser;
use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\User\v1\Update\Input\UpdateUserDto;

final readonly class Manager
{
    public function __construct(private UpdateUser $useCase)
    {
    }

    public function handle(User $user, UpdateUserDto $dto): int
    {
      return $this->useCase->handle($user, $dto);
    }
}
