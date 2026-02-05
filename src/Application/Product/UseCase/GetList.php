<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Service\Filter\Filter;
use App\Domain\Product\Repository\ProductRepository;
use App\Infrastructure\Http\Api\Product\v1\List\Input\ProductFilterDto;

final readonly class GetList
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function handle(ProductFilterDto $dto): array
    {
        $filter = new Filter();

        if ($dto->name) {
            $filter->setFields(['name' => $dto->name]);
        }

        if ($dto->sort) {
            $filter->setSort('price', $dto->sort);
        }

        return $this->repository->getList($filter);
    }
}
