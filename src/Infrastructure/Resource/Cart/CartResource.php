<?php

declare(strict_types=1);

namespace App\Infrastructure\Resource\Cart;

use App\Domain\Cart\Entity\Cart;
use App\Domain\Product\Entity\Product;
use App\Infrastructure\Contract\ResourceInterface;
use App\Infrastructure\Resource\Product\ProductResource;

final readonly class CartResource implements ResourceInterface
{
    public function __construct(private Cart $cart)
    {
    }

    public function present(): array
    {
        return [
            'id' => $this->cart->getId(),
            'products' => $this->cart
                ->getProducts()
                ->map(
                    fn(Product $product) => new ProductResource($product)->present()
                )
        ];
    }
}
