<?php

namespace Mca\Captcha\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Mca\Captcha\Services\CaptchaManager;

class Captcha extends Component
{
    public function __construct(
        public ?string $action = null,
    ) {}

    public function render(): View
    {
        $manager = app(CaptchaManager::class);
        $config = $manager->clientConfig();

        return view('mca-captcha::components.captcha', [
            'driver' => $config['driver'] ?? 'none',
            'config' => $config,
            'action' => $this->action ?? 'submit',
            'enabled' => $manager->enabled() && ($config['driver'] ?? 'none') !== 'none',
        ]);
    }
}
