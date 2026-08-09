<?php

namespace Mca\Captcha\Services;

use Illuminate\Support\Facades\Crypt;
use Mca\Captcha\Models\CaptchaSetting;

class CaptchaSettingsStore
{
    /** @var array<string, string|null>|null */
    protected static ?array $cache = null;

    public function all(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        try {
            $rows = CaptchaSetting::query()->get(['key', 'value', 'is_secret']);
        } catch (\Throwable) {
            return static::$cache = [];
        }

        $out = [];
        foreach ($rows as $row) {
            $value = $row->value;
            if ($row->is_secret && is_string($value) && $value !== '') {
                try {
                    $value = Crypt::decryptString($value);
                } catch (\Throwable) {
                    // keep ciphertext if decrypt fails
                }
            }
            $out[$row->key] = $value;
        }

        return static::$cache = $out;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public function put(string $key, ?string $value, bool $isSecret = false): void
    {
        $stored = $value;
        if ($isSecret && is_string($value) && $value !== '') {
            $stored = Crypt::encryptString($value);
        }

        CaptchaSetting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $stored, 'is_secret' => $isSecret]
        );

        static::$cache = null;
    }

    /** @param  array<string, array{value: ?string, secret?: bool}>  $pairs */
    public function putMany(array $pairs): void
    {
        foreach ($pairs as $key => $meta) {
            $this->put($key, $meta['value'] ?? null, (bool) ($meta['secret'] ?? false));
        }
    }

    public function forgetCache(): void
    {
        static::$cache = null;
    }
}
