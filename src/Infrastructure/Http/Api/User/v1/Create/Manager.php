<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Create;

use App\Application\User\Exception\UserAlreadyExistsException;
use App\Application\User\UseCase\CreateUser;
use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\User\v1\Create\Input\CreateUserDto;

final readonly class Manager
{
    public function __construct(private CreateUser $useCase)
    {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function handle(CreateUserDto $dto): User
    {
        return $this->useCase->handle($dto);
    }
}
