<?php

namespace App\Helpers;

class FieldCleanerHelper
{
    public static function sanitize(string|null $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        $value = preg_replace('/[^A-Za-z0-9\s]/', '', $value);
        $value = preg_replace('/\s+/', '', $value);
        return trim($value);
    }
}
