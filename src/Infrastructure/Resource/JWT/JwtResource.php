<?php

declare(strict_types=1);

namespace App\Infrastructure\Resource\JWT;

use App\Infrastructure\Contract\ResourceInterface;

final readonly class JwtResource implements ResourceInterface
{
    public function __construct(private string $jwt)
    {
    }

    public function present(): array
    {
        return [
            'token' => $this->jwt,
        ];
    }
}
