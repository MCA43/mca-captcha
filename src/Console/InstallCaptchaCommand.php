<?php

namespace Mca\Captcha\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Mca\Captcha\Support\McaCaptchaLocale;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'mca:captcha:install')]
class InstallCaptchaCommand extends Command
{
    protected $signature = 'mca:captcha:install
                            {--no-assets : Skip CSS publish}';

    protected $description = 'Install MCA Captcha (migration, assets)';

    public function handle(): int
    {
        McaCaptchaLocale::apply();

        $this->components->info(mca_cap('console.install.start'));

        if (! file_exists(config_path('captcha.php'))) {
            $this->callSilent('vendor:publish', ['--tag' => 'mca-captcha-config']);
        }
        $this->components->task(mca_cap('console.install.config_ready'), fn () => true);

        if (! $this->option('no-assets')) {
            $this->callSilent('vendor:publish', [
                '--tag' => 'mca-captcha-assets',
                '--force' => true,
            ]);
            $this->components->task(mca_cap('console.install.assets_published'), fn () => true);
        }

        Artisan::call('migrate', ['--force' => true]);
        $this->output->write(Artisan::output());
        $this->components->task(mca_cap('console.install.migration_done'), fn () => true);

        $this->newLine();
        $this->components->info(mca_cap('console.install.done'));
        $this->line('  '.mca_cap('console.install.web_ui', [
            'prefix' => config('captcha.routes.web.prefix', 'mca/captcha'),
        ]));

        return self::SUCCESS;
    }
}
