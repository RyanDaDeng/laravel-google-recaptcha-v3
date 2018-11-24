<?php

namespace RyanDeng\GoogleReCaptcha\Facades;

use Illuminate\Support\Facades\Facade;
use RyanDeng\GoogleReCaptcha\Core\ReCaptchaResponse;

/**
 * @method static ReCaptchaResponse verifyResponse(array $data)
 * @method static \RyanDeng\GoogleReCaptcha\GoogleReCaptcha setAction(string $value)
 * @method static render(...$names)
 * @see ReCaptcha
 */
class GoogleReCaptcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GoogleReCaptcha';
    }
}
