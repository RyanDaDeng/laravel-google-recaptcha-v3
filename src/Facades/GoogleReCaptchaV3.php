<?php

namespace RyanDeng\GoogleReCaptcha\Facades;

use Illuminate\Support\Facades\Facade;
use RyanDeng\GoogleReCaptcha\Core\GoogleReCaptchaV3Response;

/**
 * @method static GoogleReCaptchaV3Response verifyResponse(array $data)
 * @method static \RyanDeng\GoogleReCaptcha\GoogleReCaptchaV3 setAction(string $value)
 * @method static render(...$names)
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
