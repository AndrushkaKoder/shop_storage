<?php

declare(strict_types=1);

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\Entity\EntityInterface;

interface AbstractRepositoryInterface
{
    public function findById(int $id): ?EntityInterface;

    public function create(EntityInterface $entity): EntityInterface;

    public function delete(int $id): int;
}
