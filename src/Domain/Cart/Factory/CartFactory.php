<?php

declare(strict_types=1);

namespace App\Domain\Cart\Factory;

use App\Domain\Cart\Entity\Cart;
use App\Domain\Product\Factory\ProductFactory;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

class CartFactory extends PersistentObjectFactory
{
    protected function defaults(): array|callable
    {
        return [
            'totalSum' => self::faker()->randomFloat(),
            'products' => ProductFactory::new()->many(3),
        ];
    }

    public static function class(): string
    {
        return Cart::class;
    }
}
