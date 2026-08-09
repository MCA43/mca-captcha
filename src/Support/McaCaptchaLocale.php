<?php

namespace Mca\Captcha\Support;

final class McaCaptchaLocale
{
    public static function resolve(): string
    {
        $locale = config('captcha.locale');

        if (is_string($locale) && $locale !== '') {
            return $locale;
        }

        return (string) app()->getLocale();
    }

    public static function apply(): void
    {
        app()->setLocale(self::resolve());
    }
}
