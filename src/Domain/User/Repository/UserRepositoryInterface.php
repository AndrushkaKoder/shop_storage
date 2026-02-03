<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\Repository\AbstractRepositoryInterface;
use App\Domain\User\Entity\User;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    public function findByPhone(string $phone): ?User;
}
