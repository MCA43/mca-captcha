<?php

namespace Mca\Captcha\Drivers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mca\Captcha\Contracts\CaptchaDriver;

abstract class AbstractHttpDriver implements CaptchaDriver
{
    public function __construct(
        protected string $siteKey,
        protected string $secretKey,
        protected string $verifyUrl,
    ) {}

    public function isConfigured(): bool
    {
        return $this->siteKey !== '' && $this->secretKey !== '';
    }

    public function clientConfig(): array
    {
        return [
            'driver' => $this->name(),
            'site_key' => $this->siteKey,
        ];
    }

    protected function postVerify(string $response, ?string $remoteIp = null): bool
    {
        if ($response === '' || ! $this->isConfigured()) {
            return false;
        }

        try {
            $payload = [
                'secret' => $this->secretKey,
                'response' => $response,
            ];
            if ($remoteIp) {
                $payload['remoteip'] = $remoteIp;
            }

            $json = Http::asForm()
                ->timeout(8)
                ->post($this->verifyUrl, $payload)
                ->json();

            return (bool) ($json['success'] ?? false);
        } catch (\Throwable) {
            return false;
        }
    }

    protected function tokenFrom(Request $request, string $field): string
    {
        return trim((string) $request->input($field, ''));
    }
}
