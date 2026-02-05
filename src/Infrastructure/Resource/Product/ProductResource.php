<?php

declare(strict_types=1);

namespace App\Infrastructure\Resource\Product;

use App\Domain\Product\Entity\Product;
use App\Infrastructure\Contract\ResourceInterface;

final readonly class ProductResource implements ResourceInterface
{
    public function __construct(private Product $product)
    {
    }

    public function present(): array
    {
        return [
            'id' => $this->product->getId(),
            'name' => $this->product->getName(),
            'images' => $this->product->getImages(),
            'price' => $this->product->getTotalPrice(),
            'categories' => $this->product->getCategories(),
            'createdAt' => $this->product->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param array $products
     * @return array<int, Product>
     */
    public static function collect(array $products): array
    {
        return array_map(fn(Product $product) => new self($product)->present(), $products);
    }
}
