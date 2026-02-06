<?php

declare(strict_types=1);

namespace App\Application\Cart\UseCase;

use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\User\Entity\User;

final readonly class RemoveProduct
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
    ) {
    }

    public function handle(User $user, Product $product): bool
    {
        $cart = $user->getCart();

        $managedProduct = $this->productRepository->find($product->getId());

        $cart->removeProduct($managedProduct);

        $this->cartRepository->save($cart);

        return true;
    }
}
