<?php

return [

    'enabled' => env('MCA_CAPTCHA_ENABLED', true),

    'locale' => env('MCA_CAPTCHA_LOCALE'),

    'table' => env('MCA_CAPTCHA_TABLE', 'mca_captcha_settings'),

    /*
    |--------------------------------------------------------------------------
    | Fallback when DB empty (env / published config)
    |--------------------------------------------------------------------------
    */
    'default_driver' => env('MCA_CAPTCHA_DRIVER', 'none'),

    'drivers' => [
        'recaptcha' => [
            'site_key' => env('MCA_RECAPTCHA_SITE_KEY', ''),
            'secret_key' => env('MCA_RECAPTCHA_SECRET_KEY', ''),
            'version' => env('MCA_RECAPTCHA_VERSION', 'v2'), // v2|v3
            'score_threshold' => (float) env('MCA_RECAPTCHA_SCORE', 0.5),
            'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
        ],
        'hcaptcha' => [
            'site_key' => env('MCA_HCAPTCHA_SITE_KEY', ''),
            'secret_key' => env('MCA_HCAPTCHA_SECRET_KEY', ''),
            'verify_url' => 'https://hcaptcha.com/siteverify',
        ],
        'turnstile' => [
            'site_key' => env('MCA_TURNSTILE_SITE_KEY', ''),
            'secret_key' => env('MCA_TURNSTILE_SECRET_KEY', ''),
            'verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        ],
    ],

    'routes' => [
        'load_package_routes' => env('MCA_CAPTCHA_LOAD_ROUTES', true),
        'web' => [
            'prefix' => env('MCA_CAPTCHA_ROUTE_PREFIX', 'mca/captcha'),
            'middleware' => array_filter(explode(',', (string) env(
                'MCA_CAPTCHA_MIDDLEWARE',
                'web,auth,mca.captcha.root,mca.captcha.locale'
            ))),
            'name_prefix' => 'mca.captcha.',
        ],
    ],

    'controllers' => [
        'web' => [
            'captcha' => \Mca\Captcha\Http\Controllers\Web\CaptchaController::class,
        ],
    ],

    'views' => [
        'namespace' => env('MCA_CAPTCHA_VIEW_NAMESPACE', 'mca-captcha'),
        'layout' => env('MCA_CAPTCHA_VIEW_LAYOUT', 'mca-captcha::layouts.app'),
    ],

    'ui' => [
        'title' => env('MCA_CAPTCHA_UI_TITLE'),
        'class_prefix' => 'mca-cap',
        'assets' => [
            'css' => 'vendor/mca-captcha/mca-captcha.css',
            'js' => 'vendor/mca-captcha/mca-captcha.js',
            'ui' => 'vendor/mca-permission/mca-ui.css',
            'ui_js' => 'vendor/mca-permission/mca-ui.js',
        ],
    ],

    'access' => [
        'use_permission_root' => env('MCA_CAPTCHA_USE_PERMISSION_ROOT', true),
        'role_column' => env('MCA_CAPTCHA_ROLE_COLUMN', 'role_id'),
        'root_role' => env('MCA_CAPTCHA_ROOT_ROLE', 'root'),
    ],

];
