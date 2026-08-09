<?php

use Illuminate\Support\Facades\Route;

$web = config('captcha.routes.web', []);
$prefix = $web['prefix'] ?? 'mca/captcha';
$middleware = $web['middleware'] ?? ['web', 'auth', 'mca.captcha.root', 'mca.captcha.locale'];
$namePrefix = config('captcha.routes.web.name_prefix', 'mca.captcha.');
$controllers = config('captcha.controllers.web', []);
$captcha = $controllers['captcha'] ?? \Mca\Captcha\Http\Controllers\Web\CaptchaController::class;

Route::prefix($prefix)
    ->middleware($middleware)
    ->name($namePrefix)
    ->group(function () use ($captcha) {
        Route::get('/', [$captcha, 'index'])->name('index');
        Route::put('/', [$captcha, 'update'])->name('update');
    });
