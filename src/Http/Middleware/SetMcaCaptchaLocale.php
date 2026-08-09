<?php

namespace Mca\Captcha\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mca\Captcha\Support\McaCaptchaLocale;
use Symfony\Component\HttpFoundation\Response;

class SetMcaCaptchaLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        McaCaptchaLocale::apply();

        return $next($request);
    }
}
