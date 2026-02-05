<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Entity\Category;
use App\Domain\Shared\Repository\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    protected string $entityClass = Category::class;
}
