<?php

return [
    'app' => [
        'title' => 'Captcha',
        'brand' => 'Captcha',
        'nav_aria' => 'Captcha menüsü',
    ],
    'nav' => [
        'back_mca' => 'MCA Hub',
        'settings' => 'Ayarlar',
    ],
    'pages' => [
        'index_title' => 'Captcha ayarları',
        'help' => 'Tek aktif sağlayıcı seçin. Formlarda <x-mca-captcha /> veya mca.captcha middleware kullanın.',
    ],
    'drivers' => [
        'none' => 'Kapalı',
        'recaptcha' => 'Google reCAPTCHA',
        'hcaptcha' => 'hCaptcha',
        'turnstile' => 'Cloudflare Turnstile',
    ],
    'fields' => [
        'driver' => 'Aktif sürücü',
        'site_key' => 'Site anahtarı',
        'secret_key' => 'Gizli anahtar',
        'secret_keep' => 'Mevcut gizliyi korumak için boş bırakın.',
        'version' => 'reCAPTCHA sürümü',
        'score' => 'v3 skor eşiği',
        'score_help' => '0.0 – 1.0 (yüksek = daha katı). Varsayılan 0.5.',
    ],
    'actions' => [
        'save' => 'Ayarları kaydet',
    ],
    'flash' => [
        'updated' => 'Captcha ayarları kaydedildi.',
    ],
    'errors' => [
        'root_only' => 'Captcha yönetmek yalnızca root kullanıcılar içindir.',
        'verify_failed' => 'Captcha doğrulaması başarısız. Lütfen tekrar deneyin.',
    ],
    'modal' => [
        'ok' => 'Tamam',
        'confirm' => 'Onayla',
        'cancel' => 'İptal',
        'close' => 'Kapat',
        'alert_title' => 'Bildirim',
        'confirm_title' => 'Onay',
    ],
    'console' => [
        'install' => [
            'start' => 'MCA Captcha kuruluyor…',
            'config_ready' => 'Config yayınlandı / hazır',
            'assets_published' => 'Asset’ler yayınlandı',
            'migration_done' => 'Migrasyonlar çalıştırıldı',
            'done' => 'MCA Captcha kuruldu.',
            'web_ui' => 'Yönetim arayüzü: /:prefix',
        ],
    ],
];
