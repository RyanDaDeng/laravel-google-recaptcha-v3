<?php

namespace RyanDeng\GoogleReCaptcha\Providers;


use RyanDeng\GoogleReCaptcha\Configurations\ReCaptchaConfig;
use RyanDeng\GoogleReCaptcha\Core\CurlRequestClient;
use RyanDeng\GoogleReCaptcha\Interfaces\ReCaptchaConfigInterface;
use RyanDeng\GoogleReCaptcha\Interfaces\RequestClientInterface;
use RyanDeng\GoogleReCaptcha\GoogleReCaptcha;
use Illuminate\Support\ServiceProvider;


class GoogleReCaptchaServiceProvider extends ServiceProvider
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

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'GoogleReCaptcha');

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
            __DIR__ . '/../../config/googlerecaptcha.php', 'googlerecaptcha'
        );
        $this->app->bind(
            ReCaptchaConfigInterface::class,
            ReCaptchaConfig::class
        );
        
        $this->app->bind(
            RequestClientInterface::class,
            CurlRequestClient::class
        );

        $this->app->bind('GoogleReCaptcha', function () {
            return new GoogleReCaptcha(app(ReCaptchaConfigInterface::class), app(RequestClientInterface::class));
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
            __DIR__ . '/../../config/googlerecaptcha.php' => config_path('googlerecaptcha.php'),
        ], 'googlerecaptcha.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../../resources/views' => base_path('resources/views'),
        ], 'googlerecaptcha.views');
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
            'GoogleReCaptcha',
        ];
    }
}
