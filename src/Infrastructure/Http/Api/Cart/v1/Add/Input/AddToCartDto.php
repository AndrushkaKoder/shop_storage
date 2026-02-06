<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Cart\v1\Add\Input;

use Symfony\Component\Validator\Constraints as Assert;

final class AddToCartDto
{
    public function __construct(
        #[Assert\Type('integer')]
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $productId,
    ) {
    }
}
