<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Remove;

use App\Application\User\UseCase\RemoveUser;
use App\Domain\User\Entity\User;

final readonly class Manager
{
    public function __construct(private RemoveUser $useCase)
    {
    }

    public function handle(User $user): bool
    {
        return $this->useCase->handle($user);
    }
}
