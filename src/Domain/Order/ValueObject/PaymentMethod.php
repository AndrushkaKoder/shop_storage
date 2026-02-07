<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

enum PaymentMethod: string
{
    case CASH = 'CASH';
    case CARD = 'CARD';
    case TRANSFER = 'TRANSFER';
    case CRYPTO = 'CRYPTO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
