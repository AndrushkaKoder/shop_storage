<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Product\v1\List;

use App\Application\Product\UseCase\GetList;
use App\Infrastructure\Http\Api\Product\v1\List\Input\ProductFilterDto;

final readonly class Manager
{
    public function __construct(private GetList $useCase)
    {
    }

    public function handle(ProductFilterDto $dto): array
    {
        return $this->useCase->handle($dto);
    }
}
