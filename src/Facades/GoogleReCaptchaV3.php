<?php

namespace TimeHunter\LaravelGoogleCaptchaV3\Facades;

use Illuminate\Support\Facades\Facade;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GoogleReCaptchaV3Response;

/**
 * @method static GoogleReCaptchaV3Response verifyResponse(array $data)
 * @method static \TimeHunter\LaravelGoogleCaptchaV3\GoogleReCaptchaV3 setAction(string $value)
 * @method static render($action)
 * @see ReCaptcha
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
