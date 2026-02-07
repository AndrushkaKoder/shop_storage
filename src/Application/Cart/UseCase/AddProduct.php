<?php

declare(strict_types=1);

namespace App\Application\Cart\UseCase;

use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Entity\Product;
use App\Domain\User\Entity\User;

final readonly class AddProduct
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function handle(User $user, Product $product): bool
    {
        $cart = $user->getCart()->addProduct($product);

        $this->cartRepository->create($cart);

        return true;
    }
}
