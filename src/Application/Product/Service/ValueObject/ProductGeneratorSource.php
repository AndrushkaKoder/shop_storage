<?php

declare(strict_types=1);

namespace App\Application\Product\Service\ValueObject;

enum ProductGeneratorSource: string
{
    case FILE = 'file';
    case RANDOM = 'random';
    case PARSER = 'parser';
}
