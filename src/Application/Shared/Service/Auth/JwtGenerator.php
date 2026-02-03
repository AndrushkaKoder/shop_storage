<?php

declare(strict_types=1);

namespace App\Application\Shared\Service\Auth;

use App\Application\Shared\Contract\TokenGenerator;
use App\Domain\User\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;

readonly class JwtGenerator implements TokenGenerator
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder
    ) {
    }

    /**
     * @param User $user
     * @return string
     * @throws JWTEncodeFailureException
     */
    public function generate(User $user): string
    {
        return $this->jwtEncoder->encode([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'exp' => time() + (3600 * 12),
        ]);
    }
}
