<?php

declare(strict_types=1);

namespace App\Application\User\Exception;

use Symfony\Component\HttpFoundation\Response;

class AuthException extends \Exception
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Unauthenticated', Response::HTTP_UNAUTHORIZED, $previous);
    }
}
