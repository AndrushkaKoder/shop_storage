<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\Repository\AbstractRepository;
use App\Domain\User\Entity\User;

class UserRepository extends AbstractRepository
{
    protected string $entityClass = User::class;

    public function findByPhone(string $phone): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
