<?php

namespace App\Infrastructure\Http\Api\User\v1\Auth\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class AuthUserDto
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $phone,

        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $password,
    ) {
    }
}
