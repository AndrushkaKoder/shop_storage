<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\Shared\Helper\StringHelper;
use App\Application\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Http\Api\User\v1\Create\Input\CreateUserDto;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @param CreateUserDto $dto
     * @return User
     * @throws UserAlreadyExistsException
     */
    public function handle(CreateUserDto $dto): User
    {
        if ($this->repository->findByPhone($dto->phone)) {
            throw new UserAlreadyExistsException();
        }

        $user = new User();

        $user->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setPhone(StringHelper::normalizePhone($dto->phone))
            ->setPassword($this->passwordHasher->hashPassword($user, $dto->password))
            ->setRoles()
            ->setIsActive(true);

        return $this->repository->create($user);
    }
}
