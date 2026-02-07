<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

enum Status: string
{
    case NEW = 'NEW';
    case DELIVERY = 'DELIVERY';
    case SUCCESS = 'SUCCESS';
    case CANCELLED = 'CANCELLED';
}
