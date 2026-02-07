<?php

declare(strict_types=1);

namespace App\Application\Shared\Contract;

interface EntityGenerator
{
    public function generate(?int $count = null): \Generator;
}
