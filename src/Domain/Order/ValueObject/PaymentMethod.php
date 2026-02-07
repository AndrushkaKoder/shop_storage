<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

use phpDocumentor\Reflection\Types\Self_;

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
