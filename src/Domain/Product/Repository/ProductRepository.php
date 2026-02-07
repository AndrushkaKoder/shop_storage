<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Application\Product\Service\Filter\Filter;
use App\Domain\Product\Entity\Product;
use App\Domain\Shared\Repository\AbstractRepository;

class ProductRepository extends AbstractRepository
{
    protected string $entityClass = Product::class;

    public function getList(Filter $filter): array
    {
        $builder = $this->createQueryBuilder('p');

        return $filter
            ->apply($builder)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param iterable<int, Product> $products
     */
    public function createMany(iterable $products): bool
    {
        foreach ($products as $product) {
            $this->manager->persist($product);
        }

        $this->manager->flush();

        return true;
    }
}
