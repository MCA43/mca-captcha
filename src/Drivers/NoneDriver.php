<?php

namespace Mca\Captcha\Drivers;

use Illuminate\Http\Request;
use Mca\Captcha\Contracts\CaptchaDriver;

class NoneDriver implements CaptchaDriver
{
    public function name(): string
    {
        return 'none';
    }

    public function isConfigured(): bool
    {
        return true;
    }

    public function clientConfig(): array
    {
        return ['driver' => 'none'];
    }

    public function verify(Request $request): bool
    {
        return true;
    }

    public function responseField(): string
    {
        return '';
    }
}
