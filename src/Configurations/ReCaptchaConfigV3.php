<?php

namespace TimeHunter\LaravelGoogleCaptchaV3\Configurations;


use TimeHunter\LaravelGoogleCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;

class ReCaptchaConfigV3 implements ReCaptchaConfigV3Interface
{
    /**
     * @return string
     */
    public function isServiceEnabled()
    {
        return config('googlerecaptchav3.site_key');
    }

    /**
     * @return string
     */
    public function getSiteVerifyUrl()
    {
        return config('googlerecaptchav3.site_verify_url');
    }

    /**
     * @return string
     */
    public function getHostName()
    {
        return config('googlerecaptchav3.host_name');
    }

    /**
     * @return bool
     */
    public function isScoreEnabled()
    {
        return config('googlerecaptchav3.is_score_enabled');
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return config('googlerecaptchav3.secret_key');
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return config('googlerecaptchav3.template');
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return config('googlerecaptchav3.site_key');
    }


    /**
     * @return array
     */
    public function getOptions()
    {

        return config('googlerecaptchav3.options');
    }


    /**
     * @return array
     */
    public function getSetting()
    {
        return config('googlerecaptchav3.setting');
    }
}