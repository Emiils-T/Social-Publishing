<?php

namespace App\Helpers;

class XssPreventionHelper
{
    public static function clean($input): string|array
    {
        if (is_array($input)) {
            return array_map([self::class, 'clean'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeHtml($input): string
    {
        return strip_tags($input, '<p><br><strong><em><ul><ol><li>');
    }
}
