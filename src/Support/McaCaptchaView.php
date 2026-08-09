<?php

namespace Mca\Captcha\Support;

use Illuminate\Contracts\View\View;

final class McaCaptchaView
{
    public static function layout(): string
    {
        return (string) config('captcha.views.layout', 'mca-captcha::layouts.app');
    }

    public static function render(string $view, array $data = []): View
    {
        McaCaptchaLocale::apply();

        $namespace = config('captcha.views.namespace', 'mca-captcha');

        return view($namespace.'::'.$view, array_merge([
            'mcaCapTitle' => config('captcha.ui.title') ?: mca_cap('app.title'),
        ], $data));
    }

    public static function uiCssUrl(): string
    {
        return asset((string) config('captcha.ui.assets.ui', 'vendor/mca-permission/mca-ui.css'));
    }

    public static function uiJsUrl(): string
    {
        return asset((string) config('captcha.ui.assets.ui_js', 'vendor/mca-permission/mca-ui.js'));
    }

    public static function cssUrl(): string
    {
        return asset((string) config('captcha.ui.assets.css', 'vendor/mca-captcha/mca-captcha.css'));
    }

    public static function jsUrl(): string
    {
        return asset((string) config('captcha.ui.assets.js', 'vendor/mca-captcha/mca-captcha.js'));
    }
}
