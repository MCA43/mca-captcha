<?php

namespace Mca\Captcha\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCaptchaSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $driver = $this->input('driver');

        $rules = [
            'driver' => ['required', Rule::in(['none', 'recaptcha', 'hcaptcha', 'turnstile'])],
        ];

        if ($driver === 'recaptcha') {
            $rules['recaptcha_site_key'] = ['required', 'string', 'max:255'];
            $rules['recaptcha_secret_key'] = ['nullable', 'string', 'max:255'];
            $rules['recaptcha_version'] = ['required', Rule::in(['v2', 'v3'])];
            $rules['recaptcha_score_threshold'] = ['nullable', 'numeric', 'min:0', 'max:1'];
        }

        if ($driver === 'hcaptcha') {
            $rules['hcaptcha_site_key'] = ['required', 'string', 'max:255'];
            $rules['hcaptcha_secret_key'] = ['nullable', 'string', 'max:255'];
        }

        if ($driver === 'turnstile') {
            $rules['turnstile_site_key'] = ['required', 'string', 'max:255'];
            $rules['turnstile_secret_key'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
