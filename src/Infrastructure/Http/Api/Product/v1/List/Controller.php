<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Product\v1\List;

use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\Product\v1\List\Input\ProductFilterDto;
use App\Infrastructure\Resource\Product\ProductResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[OA\Tag(name: 'Product')]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/products', name: 'product.index', methods: ['GET'])]
    public function __invoke(#[MapQueryString] ProductFilterDto $dto, Manager $manager): JsonResponse
    {
        $products = $manager->handle($dto);

        return $this->wrapResponse(ProductResource::collect($products));
    }
}
