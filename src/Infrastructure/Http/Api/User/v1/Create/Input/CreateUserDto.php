<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Create\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Обязательно для заполнения')]
        public ?string $firstName,

        #[Assert\NotBlank(message: 'Обязательно для заполнения')]
        public ?string $lastName,

        #[Assert\NotBlank]
        #[Assert\Length(exactly: 10, exactMessage: 'Нужно ровно 10 цифр')]
        #[Assert\Regex(pattern: '/^\d+$/', message: 'Только цифры')]
        public ?string $phone,

        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public ?string $password
    ) {
    }
}
