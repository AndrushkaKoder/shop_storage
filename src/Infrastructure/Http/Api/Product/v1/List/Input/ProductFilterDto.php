<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Product\v1\List\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ProductFilterDto
{
    public function __construct(
        #[Assert\Type('string')]
        public ?string $name = null,
        #[Assert\Type('string')]
        public ?string $sort = null,
    )
    {
    }
}
