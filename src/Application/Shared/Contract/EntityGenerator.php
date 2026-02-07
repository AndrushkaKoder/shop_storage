<?php

declare(strict_types=1);

namespace App\Application\Shared\Contract;

use App\Application\Product\Service\ValueObject\ProductGeneratorSource;

interface EntityGenerator
{
    public function generate(ProductGeneratorSource $source, ?int $count = null): void;
}
