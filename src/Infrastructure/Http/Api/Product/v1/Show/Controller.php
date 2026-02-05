<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Product\v1\Show;

use App\Domain\Product\Entity\Product;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Resource\Product\ProductResource;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/products/{product}', name: 'product.show', methods: ['GET'])]
    public function __invoke(#[MapEntity] Product $product): JsonResponse
    {
        return $this->wrapResponse(new ProductResource($product));
    }
}
