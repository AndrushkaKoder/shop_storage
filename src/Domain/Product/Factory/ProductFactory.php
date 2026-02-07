<?php

declare(strict_types=1);

namespace App\Domain\Product\Factory;

use App\Domain\Product\Entity\Product;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

class ProductFactory extends PersistentObjectFactory
{
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->name(),
            'price' => self::faker()->randomFloat(2, 10),
            'discount' => self::faker()->randomFloat(1, 3),
            'images' => [self::faker()->imageUrl(), self::faker()->imageUrl(), self::faker()->imageUrl()],
            'is_active' => true,
        ];
    }

    public static function class(): string
    {
        return Product::class;
    }
}
