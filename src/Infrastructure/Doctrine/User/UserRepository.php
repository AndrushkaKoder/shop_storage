<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User;

use App\Domain\Shared\Entity\EntityInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Doctrine\AbstractRepository;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected string $entityClass = User::class;

    public function findById(int $id): ?EntityInterface
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getActive(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.is_active = :is_active')
            ->setParameter('is_active', true)
            ->getQuery()
            ->getArrayResult();
    }

    public function delete(int $id): int
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->delete()
            ->setParameter('id', $id)
            ->getQuery()->execute();
    }

    public function findByPhone(string $phone): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
