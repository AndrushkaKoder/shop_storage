<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use App\Infrastructure\Http\Api\User\v1\Update\Input\UpdateUserDto;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UpdateUser
{
    public function __construct(
        private UserRepository $repository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function handle(User $user, UpdateUserDto $dto): int
    {
        $user->setFirstName($dto->firstName)
            ->setLastName($dto->lastName);

        if ($dto->password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));
        }

        $this->repository->save($user);

        return $user->getId();
    }
}
