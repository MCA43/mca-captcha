<?php

namespace Mca\Captcha\Drivers;

use Illuminate\Http\Request;

class TurnstileDriver extends AbstractHttpDriver
{
    public function name(): string
    {
        return 'turnstile';
    }

    public function responseField(): string
    {
        return 'cf-turnstile-response';
    }

    public function clientConfig(): array
    {
        return array_merge(parent::clientConfig(), [
            'script' => 'https://challenges.cloudflare.com/turnstile/v0/api.js',
        ]);
    }

    public function verify(Request $request): bool
    {
        return $this->postVerify(
            $this->tokenFrom($request, $this->responseField()),
            $request->ip()
        );
    }
}
