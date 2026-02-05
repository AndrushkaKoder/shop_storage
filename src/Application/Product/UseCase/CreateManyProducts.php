<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class CreateManyProducts
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function handle(): array
    {
        return [];
    }
}
