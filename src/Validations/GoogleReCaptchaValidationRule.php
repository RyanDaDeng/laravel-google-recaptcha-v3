<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 9/8/18
 * Time: 1:39 PM
 */

namespace RyanDeng\GoogleReCaptcha\Validations;


use Illuminate\Contracts\Validation\ImplicitRule;

use \RyanDeng\GoogleReCaptcha\Facades\GoogleReCaptchaV3;
class GoogleReCaptchaValidationRule implements ImplicitRule
{
    protected $action;
    protected $ip;
    protected $message;

    public function __construct($action = null, $ip = null)
    {
        $this->action = $action;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = GoogleReCaptchaV3::setAction($this->action)->verifyResponse($value, $this->ip);
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