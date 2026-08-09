<?php

return [
    'app' => [
        'title' => 'Captcha',
        'brand' => 'Captcha',
        'nav_aria' => 'Captcha navigation',
    ],
    'nav' => [
        'back_mca' => 'MCA Hub',
        'settings' => 'Settings',
    ],
    'pages' => [
        'index_title' => 'Captcha settings',
        'help' => 'Choose one active provider. Forms use <x-mca-captcha /> or the mca.captcha middleware.',
    ],
    'drivers' => [
        'none' => 'Disabled',
        'recaptcha' => 'Google reCAPTCHA',
        'hcaptcha' => 'hCaptcha',
        'turnstile' => 'Cloudflare Turnstile',
    ],
    'fields' => [
        'driver' => 'Active driver',
        'site_key' => 'Site key',
        'secret_key' => 'Secret key',
        'secret_keep' => 'Leave blank to keep the current secret.',
        'version' => 'reCAPTCHA version',
        'score' => 'v3 score threshold',
        'score_help' => '0.0 – 1.0 (higher = stricter). Default 0.5.',
    ],
    'actions' => [
        'save' => 'Save settings',
    ],
    'flash' => [
        'updated' => 'Captcha settings saved.',
    ],
    'errors' => [
        'root_only' => 'Only root users can manage captcha.',
        'verify_failed' => 'Captcha verification failed. Please try again.',
    ],
    'modal' => [
        'ok' => 'OK',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
        'close' => 'Close',
        'alert_title' => 'Notice',
        'confirm_title' => 'Confirm',
    ],
    'console' => [
        'install' => [
            'start' => 'Installing MCA Captcha…',
            'config_ready' => 'Config published / ready',
            'assets_published' => 'Assets published',
            'migration_done' => 'Migrations run',
            'done' => 'MCA Captcha installed.',
            'web_ui' => 'Admin UI: /:prefix',
        ],
    ],
];
