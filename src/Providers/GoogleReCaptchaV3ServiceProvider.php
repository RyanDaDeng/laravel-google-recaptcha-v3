<?php

namespace TimeHunter\LaravelGoogleReCaptchaV3\Providers;

use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\CurlRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\Configurations\ReCaptchaConfigV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;
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

        if (! $this->app->has(ReCaptchaConfigV3Interface::class)) {
            $this->app->bind(
                ReCaptchaConfigV3Interface::class,
                ReCaptchaConfigV3::class
            );
        }

        // default strategy
        if (! $this->app->has(RequestClientInterface::class)) {
            switch ($this->app->get(ReCaptchaConfigV3Interface::class)->getRequestMethod()) {
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

        $this->app->bind('GoogleReCaptchaV3', function () {
            $service = new GoogleReCaptchaV3Service(app(ReCaptchaConfigV3Interface::class), app(RequestClientInterface::class));
            return new GoogleReCaptchaV3($service);
        });
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
            __DIR__.'/../../vuejs/GoogleReCaptchaV3.vue' => resource_path('js/components/googlerecaptchav3/GoogleReCaptchaV3.vue'),
        ], 'googlerecaptchav3.vuejs');
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
