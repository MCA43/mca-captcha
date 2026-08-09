<?php

use Mca\Captcha\Services\CaptchaManager;

if (! function_exists('mca_captcha')) {
    function mca_captcha(): CaptchaManager
    {
        return app(CaptchaManager::class);
    }
}

if (! function_exists('mca_captcha_verify')) {
    function mca_captcha_verify(?\Illuminate\Http\Request $request = null): bool
    {
        return mca_captcha()->verify($request ?? request());
    }
}

if (! function_exists('mca_cap')) {
    /** @param  array<string, string|int>  $replace */
    function mca_cap(string $key, array $replace = []): string
    {
        return (string) __('mca-captcha::captcha.'.$key, $replace);
    }
}
