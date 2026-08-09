<?php

namespace Mca\Captcha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Mca\Captcha\Services\CaptchaManager;

class CaptchaVerified implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! app(CaptchaManager::class)->verify(request())) {
            $fail(mca_cap('errors.verify_failed'));
        }
    }
}
