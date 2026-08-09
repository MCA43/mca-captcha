<?php

namespace Mca\Captcha\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mca\Captcha\Services\CaptchaManager;
use Symfony\Component\HttpFoundation\Response;

class VerifyCaptcha
{
    public function __construct(
        protected CaptchaManager $captcha,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->captcha->verify($request)) {
            return back()
                ->withInput()
                ->withErrors([
                    'captcha' => mca_cap('errors.verify_failed'),
                ]);
        }

        return $next($request);
    }
}
