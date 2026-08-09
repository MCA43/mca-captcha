<?php

namespace Mca\Captcha\Contracts;

use Illuminate\Http\Request;

interface CaptchaDriver
{
    public function name(): string;

    public function isConfigured(): bool;

    /** Site key / public client config for Blade. */
    public function clientConfig(): array;

    public function verify(Request $request): bool;

    public function responseField(): string;
}
