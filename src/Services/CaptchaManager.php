<?php

namespace Mca\Captcha\Services;

use Illuminate\Http\Request;
use Mca\Captcha\Contracts\CaptchaDriver;
use Mca\Captcha\Drivers\HcaptchaDriver;
use Mca\Captcha\Drivers\NoneDriver;
use Mca\Captcha\Drivers\RecaptchaDriver;
use Mca\Captcha\Drivers\TurnstileDriver;

class CaptchaManager
{
    protected ?CaptchaDriver $resolved = null;

    public function __construct(
        protected CaptchaSettingsStore $store,
    ) {}

    public function enabled(): bool
    {
        return (bool) config('captcha.enabled', true) && $this->driverName() !== 'none';
    }

    public function driverName(): string
    {
        $fromDb = $this->store->get('driver');
        if (is_string($fromDb) && $fromDb !== '') {
            return $fromDb;
        }

        return (string) config('captcha.default_driver', 'none');
    }

    public function driver(): CaptchaDriver
    {
        if ($this->resolved) {
            return $this->resolved;
        }

        return $this->resolved = $this->makeDriver($this->driverName());
    }

    public function verify(?Request $request = null): bool
    {
        $request ??= request();

        if (! (bool) config('captcha.enabled', true)) {
            return true;
        }

        $driver = $this->driver();

        if ($driver->name() === 'none') {
            return true;
        }

        if (! $driver->isConfigured()) {
            return false;
        }

        return $driver->verify($request);
    }

    public function clientConfig(): array
    {
        return $this->driver()->clientConfig();
    }

    public function responseField(): string
    {
        return $this->driver()->responseField();
    }

    /** Settings for admin form (secrets masked). */
    public function settingsForAdmin(): array
    {
        $driver = $this->driverName();
        $cfg = config('captcha.drivers', []);

        return [
            'driver' => $driver,
            'recaptcha' => [
                'site_key' => $this->val('recaptcha.site_key', $cfg['recaptcha']['site_key'] ?? ''),
                'secret_key' => $this->masked('recaptcha.secret_key', $cfg['recaptcha']['secret_key'] ?? ''),
                'secret_set' => $this->hasSecret('recaptcha.secret_key', $cfg['recaptcha']['secret_key'] ?? ''),
                'version' => $this->val('recaptcha.version', $cfg['recaptcha']['version'] ?? 'v2'),
                'score_threshold' => $this->val('recaptcha.score_threshold', (string) ($cfg['recaptcha']['score_threshold'] ?? '0.5')),
            ],
            'hcaptcha' => [
                'site_key' => $this->val('hcaptcha.site_key', $cfg['hcaptcha']['site_key'] ?? ''),
                'secret_key' => $this->masked('hcaptcha.secret_key', $cfg['hcaptcha']['secret_key'] ?? ''),
                'secret_set' => $this->hasSecret('hcaptcha.secret_key', $cfg['hcaptcha']['secret_key'] ?? ''),
            ],
            'turnstile' => [
                'site_key' => $this->val('turnstile.site_key', $cfg['turnstile']['site_key'] ?? ''),
                'secret_key' => $this->masked('turnstile.secret_key', $cfg['turnstile']['secret_key'] ?? ''),
                'secret_set' => $this->hasSecret('turnstile.secret_key', $cfg['turnstile']['secret_key'] ?? ''),
            ],
        ];
    }

    public function forgetResolved(): void
    {
        $this->resolved = null;
        $this->store->forgetCache();
    }

    protected function makeDriver(string $name): CaptchaDriver
    {
        $cfg = config('captcha.drivers', []);

        return match ($name) {
            'recaptcha' => new RecaptchaDriver(
                $this->val('recaptcha.site_key', $cfg['recaptcha']['site_key'] ?? ''),
                $this->secret('recaptcha.secret_key', $cfg['recaptcha']['secret_key'] ?? ''),
                (string) ($cfg['recaptcha']['verify_url'] ?? 'https://www.google.com/recaptcha/api/siteverify'),
                $this->val('recaptcha.version', $cfg['recaptcha']['version'] ?? 'v2'),
                (float) $this->val('recaptcha.score_threshold', (string) ($cfg['recaptcha']['score_threshold'] ?? '0.5')),
            ),
            'hcaptcha' => new HcaptchaDriver(
                $this->val('hcaptcha.site_key', $cfg['hcaptcha']['site_key'] ?? ''),
                $this->secret('hcaptcha.secret_key', $cfg['hcaptcha']['secret_key'] ?? ''),
                (string) ($cfg['hcaptcha']['verify_url'] ?? 'https://hcaptcha.com/siteverify'),
            ),
            'turnstile' => new TurnstileDriver(
                $this->val('turnstile.site_key', $cfg['turnstile']['site_key'] ?? ''),
                $this->secret('turnstile.secret_key', $cfg['turnstile']['secret_key'] ?? ''),
                (string) ($cfg['turnstile']['verify_url'] ?? 'https://challenges.cloudflare.com/turnstile/v0/siteverify'),
            ),
            default => new NoneDriver,
        };
    }

    protected function val(string $key, string $fallback = ''): string
    {
        $v = $this->store->get($key);

        return is_string($v) && $v !== '' ? $v : (string) $fallback;
    }

    protected function secret(string $key, string $fallback = ''): string
    {
        return $this->val($key, $fallback);
    }

    protected function hasSecret(string $key, string $fallback = ''): bool
    {
        return $this->secret($key, $fallback) !== '';
    }

    protected function masked(string $key, string $fallback = ''): string
    {
        return $this->hasSecret($key, $fallback) ? '••••••••' : '';
    }
}
