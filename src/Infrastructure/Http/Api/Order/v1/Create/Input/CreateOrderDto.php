<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Order\v1\Create\Input;

use App\Domain\Order\ValueObject\PaymentMethod;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrderDto
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 10)]
        #[Assert\Choice(callback: [PaymentMethod::class, 'values'])]
        public string $paymentMethod,
    ) {
    }
}
