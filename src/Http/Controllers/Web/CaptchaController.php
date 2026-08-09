<?php

namespace Mca\Captcha\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Mca\Captcha\Http\Requests\UpdateCaptchaSettingsRequest;
use Mca\Captcha\Services\CaptchaManager;
use Mca\Captcha\Services\CaptchaSettingsStore;
use Mca\Captcha\Support\McaCaptchaView;

class CaptchaController extends Controller
{
    public function index(CaptchaManager $manager): View
    {
        return McaCaptchaView::render('settings.index', [
            'settings' => $manager->settingsForAdmin(),
            'activeTab' => request('tab', $manager->driverName()),
        ]);
    }

    public function update(
        UpdateCaptchaSettingsRequest $request,
        CaptchaSettingsStore $store,
        CaptchaManager $manager,
    ): RedirectResponse {
        $data = $request->validated();
        $driver = $data['driver'];

        $pairs = [
            'driver' => ['value' => $driver, 'secret' => false],
        ];

        if ($driver === 'recaptcha') {
            $pairs['recaptcha.site_key'] = ['value' => $data['recaptcha_site_key'] ?? '', 'secret' => false];
            $pairs['recaptcha.version'] = ['value' => $data['recaptcha_version'] ?? 'v2', 'secret' => false];
            $pairs['recaptcha.score_threshold'] = ['value' => (string) ($data['recaptcha_score_threshold'] ?? '0.5'), 'secret' => false];
            $secret = trim((string) ($data['recaptcha_secret_key'] ?? ''));
            if ($secret !== '' && $secret !== '••••••••') {
                $pairs['recaptcha.secret_key'] = ['value' => $secret, 'secret' => true];
            }
        }

        if ($driver === 'hcaptcha') {
            $pairs['hcaptcha.site_key'] = ['value' => $data['hcaptcha_site_key'] ?? '', 'secret' => false];
            $secret = trim((string) ($data['hcaptcha_secret_key'] ?? ''));
            if ($secret !== '' && $secret !== '••••••••') {
                $pairs['hcaptcha.secret_key'] = ['value' => $secret, 'secret' => true];
            }
        }

        if ($driver === 'turnstile') {
            $pairs['turnstile.site_key'] = ['value' => $data['turnstile_site_key'] ?? '', 'secret' => false];
            $secret = trim((string) ($data['turnstile_secret_key'] ?? ''));
            if ($secret !== '' && $secret !== '••••••••') {
                $pairs['turnstile.secret_key'] = ['value' => $secret, 'secret' => true];
            }
        }

        $store->putMany($pairs);
        $manager->forgetResolved();

        return redirect()
            ->route(config('captcha.routes.web.name_prefix', 'mca.captcha.').'index', ['tab' => $driver])
            ->with('status', mca_cap('flash.updated'));
    }
}
