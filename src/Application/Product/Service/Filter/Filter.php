<?php

declare(strict_types=1);

namespace App\Application\Product\Service\Filter;

use Doctrine\ORM\QueryBuilder;

class Filter
{
    private array $fields = [];
    private string $sortField = 'id';
    private string $sortDirection = 'DESC';

    public function setFields(array $fields): static
    {
        $this->fields = array_filter($fields, fn($v) => $v !== null && $v !== '');

        return $this;
    }

    public function setSort(string $column = 'id', string $direction = 'DESC'): static
    {
        $this->sortField = $column;
        $this->sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        return $this;
    }

    public function apply(QueryBuilder $builder): QueryBuilder
    {
        $rootAlias = 'p';

        foreach ($this->fields as $field => $value) {
            $builder->andWhere(sprintf('%s.%s = :%s', $rootAlias, $field, $field))
                ->setParameter($field, $value);
        }

        $builder->orderBy(sprintf('%s.%s', $rootAlias, $this->sortField), $this->sortDirection);

        return $builder;
    }
}
