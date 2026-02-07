<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Update\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateUserDto
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $firstName,

        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public ?string $lastName,

        #[Assert\Type('string')]
        #[Assert\Type('string')]
        #[Assert\Length(min: 8, minMessage: 'Слишком короткий пароль')]
        public ?string $password = null,
    ) {
    }
}
