<?php

namespace RyanDeng\GoogleReCaptcha\Providers;


use RyanDeng\GoogleReCaptcha\Configurations\ReCaptchaConfigV3;
use RyanDeng\GoogleReCaptcha\Core\CurlRequestClient;
use RyanDeng\GoogleReCaptcha\GoogleReCaptchaV3;
use RyanDeng\GoogleReCaptcha\Interfaces\ReCaptchaConfigV3Interface;
use RyanDeng\GoogleReCaptcha\Interfaces\RequestClientInterface;
use Illuminate\Support\ServiceProvider;


class GoogleReCaptchaV3ServiceProvider extends ServiceProvider
{

    // never defer the class, by default is false, but put here as an notice
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'GoogleReCaptchaV3');

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
            __DIR__ . '/../../config/googlerecaptchav3.php', 'googlerecaptchav3'
        );
        $this->app->bind(
            ReCaptchaConfigV3Interface::class,
            ReCaptchaConfigV3::class
        );
        
        $this->app->bind(
            RequestClientInterface::class,
            CurlRequestClient::class
        );

        $this->app->bind('GoogleReCaptchaV3', function () {
            return new GoogleReCaptchaV3(app(ReCaptchaConfigV3Interface::class), app(RequestClientInterface::class));
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
            __DIR__ . '/../../config/googlerecaptchav3.php' => config_path('googlerecaptchav3.php'),
        ], 'googlerecaptchav3.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../../resources/views' => base_path('resources/views'),
        ], 'googlerecaptchav3.views');
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
