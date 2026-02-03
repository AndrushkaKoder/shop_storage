<?php

declare(strict_types=1);

namespace App\Infrastructure\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception')]
class ApiExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
    }
}
