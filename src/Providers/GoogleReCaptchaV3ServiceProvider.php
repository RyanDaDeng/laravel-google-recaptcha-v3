<?php

namespace TimeHunter\LaravelGoogleReCaptchaV3\Providers;

use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelGoogleReCaptchaV3\Configurations\ReCaptchaConfigV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\CurlRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;

class GoogleReCaptchaV3ServiceProvider extends ServiceProvider
{
    // never defer the class, by default is false, but put here as a notice
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'GoogleReCaptchaV3');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'GoogleReCaptchaV3');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/googlerecaptchav3.php', 'googlerecaptchav3'
        );

        $laravel = app();
        $version = $laravel::VERSION;

        if (version_compare($version, '5.7.*') === 1 || version_compare($version, '5.6.*') === 1 || version_compare($version, '5.5.*') === 1) {
            if (! $this->app->has(ReCaptchaConfigV3Interface::class)) {
                $this->bindConfig();
            }

            if (! $this->app->has(RequestClientInterface::class)) {
                $this->bindRequest($this->app->get(ReCaptchaConfigV3Interface::class)->getRequestMethod());
            }
        } else {
            $this->bindConfig();
            $this->bindRequest(app(ReCaptchaConfigV3Interface::class)->getRequestMethod());
        }

        $this->app->bind('GoogleReCaptchaV3', function () {
            $service = new GoogleReCaptchaV3Service(app(ReCaptchaConfigV3Interface::class), app(RequestClientInterface::class));

            return new GoogleReCaptchaV3($service);
        });
    }

    /**
     * Bind config.
     */
    public function bindConfig()
    {
        $this->app->bind(
            ReCaptchaConfigV3Interface::class,
            ReCaptchaConfigV3::class
        );
    }

    /**
     * @param $method
     */
    public function bindRequest($method)
    {
        switch ($method) {
            case 'guzzle':
                $this->app->bind(
                    RequestClientInterface::class,
                    GuzzleRequestClient::class
                );
                break;
            case'curl':
                $this->app->bind(
                    RequestClientInterface::class,
                    CurlRequestClient::class
                );
                break;
            default:
                $this->app->bind(
                    RequestClientInterface::class,
                    CurlRequestClient::class
                );
                break;
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../../config/googlerecaptchav3.php' => config_path('googlerecaptchav3.php'),
        ], 'googlerecaptchav3.config');

        // Publishing the vue component file.
        $this->publishes([
            __DIR__.'/../../vuejs/GoogleReCaptchaV3.vue' => base_path('resources/js/components/googlerecaptchav3/GoogleReCaptchaV3.vue'),
        ], 'googlerecaptchav3.vuejs');

        // Publishing the lang file.
        $this->publishes([
            __DIR__.'/../../resources/lang' => base_path('resources/lang/vendor/GoogleReCaptchaV3'),
        ], 'googlerecaptchav3.lang');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // define a list of provider names
        return [
            'GoogleReCaptchaV3',
        ];
    }
}
