# MCA Captcha

Laravel captcha package: **reCAPTCHA**, **hCaptcha**, **Cloudflare Turnstile** — one active driver.

## Install

```bash
composer require mca/captcha
php artisan mca:captcha:install
```

Admin: `/mca/captcha` (root only).

## Usage

Blade:

```blade
<form method="post">
    @csrf
    <x-mca-captcha />
    <button type="submit">Send</button>
</form>
```

Validation rule:

```php
use Mca\Captcha\Rules\CaptchaVerified;

$request->validate([
    // ...
    'captcha' => [new CaptchaVerified],
]);
```

Middleware on a route group:

```php
Route::middleware('mca.captcha')->group(...);
```

Helper:

```php
mca_captcha_verify($request);
```
