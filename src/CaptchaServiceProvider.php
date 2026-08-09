<?php

namespace Mca\Captcha;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Mca\Captcha\Console\InstallCaptchaCommand;
use Mca\Captcha\Http\Middleware\EnsureMcaCaptchaRoot;
use Mca\Captcha\Http\Middleware\SetMcaCaptchaLocale;
use Mca\Captcha\Http\Middleware\VerifyCaptcha;
use Mca\Captcha\Services\CaptchaManager;
use Mca\Captcha\Services\CaptchaSettingsStore;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/captcha.php', 'captcha');
        $this->app->singleton(CaptchaSettingsStore::class);
        $this->app->singleton(CaptchaManager::class);
    }

    public function boot(): void
    {
        if (! config('captcha.enabled', true)) {
            return;
        }

        $this->registerPublishing();
        $this->registerMiddleware();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'mca-captcha');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mca-captcha');
        $this->registerRoutes();
        $this->registerHub();
        $this->registerBlade();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCaptchaCommand::class,
            ]);
        }
    }

    protected function registerHub(): void
    {
        if (! function_exists('mca_hub_register')) {
            return;
        }

        mca_hub_register('captcha', [
            'enabled' => fn () => (bool) config('captcha.enabled', true),
        ]);
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/captcha.php' => config_path('captcha.php'),
        ], 'mca-captcha-config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/mca-captcha'),
        ], 'mca-captcha-assets');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/mca-captcha'),
        ], 'mca-captcha-views');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'mca-captcha-migrations');
    }

    protected function registerMiddleware(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];
        $router->aliasMiddleware('mca.captcha.root', EnsureMcaCaptchaRoot::class);
        $router->aliasMiddleware('mca.captcha.locale', SetMcaCaptchaLocale::class);
        $router->aliasMiddleware('mca.captcha', VerifyCaptcha::class);
    }

    protected function registerRoutes(): void
    {
        if (! config('captcha.routes.load_package_routes', true)) {
            return;
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    protected function registerBlade(): void
    {
        $this->loadViewComponentsAs('mca', [
            \Mca\Captcha\View\Components\Captcha::class,
        ]);
    }
}
