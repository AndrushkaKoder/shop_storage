<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Cart\v1\Remove;

use App\Application\Cart\UseCase\RemoveProduct;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\Cart\v1\Remove\Input\RemoveFromCartDto;
use Doctrine\ORM\EntityNotFoundException;

final readonly class Manager
{
    public function __construct(private RemoveProduct $useCase, private ProductRepository $productRepository)
    {
    }

    public function handle(User $user, RemoveFromCartDto $dto): bool
    {
        /** @var Product|null $product */
        $product = $this->productRepository->findById($dto->productId);

        if (!$product) {
            throw new EntityNotFoundException();
        }

        return $this->useCase->handle($user, $product);
    }
}
