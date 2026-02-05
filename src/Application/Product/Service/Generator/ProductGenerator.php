<?php

declare(strict_types=1);

namespace App\Application\Product\Service\Generator;

use App\Application\Shared\Contract\EntityGenerator;
use App\Domain\Product\Entity\Product;
use Generator;

class ProductGenerator implements EntityGenerator
{
    public function generate(?int $count = null): Generator
    {
        for ($i = 0; $i < $count ?? 10; $i++) {
            $product = new Product();

            $product->setName("Product_{$i}");
            $product->setPrice($i * rand(1, 100));

            if ($i % 2 === 0) {
                $product->setDiscount($i * 2);
            }

            $product->setImages([
                'https://iphoriya.ru/wp-content/uploads/iphone-17-pro-deep-blue.webp',
                'https://iphoriya.ru/wp-content/uploads/iphone-15-black.jpg'
            ]);

            $product->setIsActive(true);

            yield $product;
        }
    }
}
