<?php

namespace Mca\Captcha\Drivers;

use Illuminate\Http\Request;

class HcaptchaDriver extends AbstractHttpDriver
{
    public function name(): string
    {
        return 'hcaptcha';
    }

    public function responseField(): string
    {
        return 'h-captcha-response';
    }

    public function clientConfig(): array
    {
        return array_merge(parent::clientConfig(), [
            'script' => 'https://js.hcaptcha.com/1/api.js',
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
