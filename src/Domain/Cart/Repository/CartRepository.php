<?php

declare(strict_types=1);

namespace App\Domain\Cart\Repository;

use App\Domain\Cart\Entity\Cart;
use App\Domain\Shared\Repository\AbstractRepository;

class CartRepository extends AbstractRepository
{
    protected string $entityClass = Cart::class;
}
