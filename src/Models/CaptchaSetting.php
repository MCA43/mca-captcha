<?php

namespace Mca\Captcha\Models;

use Illuminate\Database\Eloquent\Model;

class CaptchaSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'is_secret',
    ];

    protected function casts(): array
    {
        return [
            'is_secret' => 'boolean',
        ];
    }

    public function getTable(): string
    {
        return (string) config('captcha.table', 'mca_captcha_settings');
    }
}
