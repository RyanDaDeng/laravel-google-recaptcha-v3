<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 9/8/18
 * Time: 1:39 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Validations;

use Illuminate\Contracts\Validation\ImplicitRule;
use TimeHunter\LaravelGoogleReCaptchaV3\Facades\GoogleReCaptchaV3;

class GoogleReCaptchaV3ValidationRule implements ImplicitRule
{
    protected $action;
    protected $ip;
    protected $message;

    public function __construct($action = null)
    {
        $this->action = $action;
    }

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = GoogleReCaptchaV3::setAction($this->action)->verifyResponse($value, app('request')->getClientIp());
        $this->message = $response->getMessage();

        return $response->isSuccess();
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
