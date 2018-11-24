<?php

namespace RyanDeng\GoogleReCaptcha\Configurations;


use RyanDeng\GoogleReCaptcha\Interfaces\ReCaptchaConfigInterface;

class ReCaptchaConfig implements ReCaptchaConfigInterface
{
    /**
     * @return string
     */
    public function isServiceEnabled()
    {
        return config('googlerecaptcha.site_key');
    }

    /**
     * @return string
     */
    public function getSiteVerifyUrl()
    {
        return config('googlerecaptcha.site_verify_url');
    }

    /**
     * @return string
     */
    public function getHostName()
    {
        return config('googlerecaptcha.host_name');
    }

    /**
     * @return bool
     */
    public function isScoreEnabled()
    {
        return config('googlerecaptcha.is_score_enabled');
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return config('googlerecaptcha.secret_key');
    }

    /**
     * @return int
     */
    public function getCurlTimeout()
    {
        return config('googlerecaptcha.options.curl_timeout');
    }

    /**
     * @return bool
     */
    public function getCurlVerify()
    {
        return config('googlerecaptcha.options.curl_verify');
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return config('googlerecaptcha.template');
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return config('googlerecaptcha.site_key');
    }


    /**
     * @return array
     */
    public function getOptions()
    {

        return config('googlerecaptcha.options');
    }


    /**
     * @return array
     */
    public function getScoreSetting()
    {
        return config('googlerecaptcha.score_setting');
    }
}