<?php

declare(strict_types=1);

namespace App\Application\User\Exception;

class UserAlreadyExistsException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            'Пользователь с данным телефоном был зарегистрирован ранее',
            422,
            $previous
        );
    }
}
