<?php

declare(strict_types=1);

namespace App\Application\Shared\Messenger\Message\Product;

use App\Application\Shared\Messenger\Contract\AsyncMessageInterface;

final readonly class CreateProductAsync implements AsyncMessageInterface
{
    public function __construct(public string $source)
    {
    }
}
