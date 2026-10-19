<?php

namespace MiniErp\Support;

class Helpers
{
    public static function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }

    public static function moneyToCents(float|int|string $value): int
    {
        return (int) round((float) $value * 100);
    }

    public static function centsToMoney(int $value): float
    {
        return round($value / 100, 2);
    }

    public static function isAllowedStatus(string $status, array $allowed): bool
    {
        return in_array($status, $allowed, true);
    }

    public static function asIntArray(array $raw): array
    {
        return array_map('intval', array_values(array_filter($raw, 'is_numeric')));
    }
}
