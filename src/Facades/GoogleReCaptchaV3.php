<?php

namespace TimeHunter\LaravelGoogleReCaptchaV3\Facades;

use Illuminate\Support\Facades\Facade;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;

/**
 * @method static GoogleReCaptchaV3Response verifyResponse($value, $ip = null)
 * @method static \TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3 setAction(string $value)
 * @method static render($mappers)
 * @see \TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3
 */
class GoogleReCaptchaV3 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GoogleReCaptchaV3';
    }
}
