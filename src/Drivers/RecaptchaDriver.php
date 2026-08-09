<?php

namespace Mca\Captcha\Drivers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaDriver extends AbstractHttpDriver
{
    public function __construct(
        string $siteKey,
        string $secretKey,
        string $verifyUrl,
        protected string $version = 'v2',
        protected float $scoreThreshold = 0.5,
    ) {
        parent::__construct($siteKey, $secretKey, $verifyUrl);
    }

    public function name(): string
    {
        return 'recaptcha';
    }

    public function responseField(): string
    {
        return 'g-recaptcha-response';
    }

    public function clientConfig(): array
    {
        return array_merge(parent::clientConfig(), [
            'version' => $this->version,
            'script' => 'https://www.google.com/recaptcha/api.js'.($this->version === 'v3' ? '?render='.urlencode($this->siteKey) : ''),
        ]);
    }

    public function verify(Request $request): bool
    {
        $token = $this->tokenFrom($request, $this->responseField());
        if ($token === '' || ! $this->isConfigured()) {
            return false;
        }

        try {
            $json = Http::asForm()
                ->timeout(8)
                ->post($this->verifyUrl, [
                    'secret' => $this->secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])
                ->json();

            if (! ($json['success'] ?? false)) {
                return false;
            }

            if ($this->version === 'v3') {
                $score = (float) ($json['score'] ?? 0);

                return $score >= $this->scoreThreshold;
            }

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
