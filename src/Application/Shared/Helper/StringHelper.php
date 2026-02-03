<?php

declare(strict_types=1);

namespace App\Application\Shared\Helper;

final class StringHelper
{
    private function __construct()
    {
    }

    public static function toLower(string $value): string
    {
        return mb_strtolower($value);
    }

    public static function normalizePhone(string $phone): string
    {
        return preg_replace('/\D+/', '', self::toLower($phone));
    }
}
