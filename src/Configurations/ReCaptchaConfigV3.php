<?php

namespace TimeHunter\LaravelGoogleReCaptchaV3\Configurations;

use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;

class ReCaptchaConfigV3 implements ReCaptchaConfigV3Interface
{
    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return config('googlerecaptchav3.request_method');
    }

    /**
     * @return string
     */
    public function isServiceEnabled()
    {
        return config('googlerecaptchav3.is_service_enabled');
    }

    /**
     * @return string
     */
    public function getApiJsUrl()
    {
        return config('googlerecaptchav3.api_js_url');
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

    /**
     * @return bool
     */
    public function isInline()
    {
        return config('googlerecaptchav3.inline');
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return config('googlerecaptchav3.language');
    }

    /**
     * @return string
     */
    public function getSkipIps()
    {
        return config('googlerecaptchav3.skip_ips');
    }

    /**
     * @return bool
     */
    public function getBackgroundBadgeDisplay()
    {
        return config('googlerecaptchav3.background_badge_display');
    }

    /**
     * @return bool
     */
    public function shouldEnableBackgroundMode()
    {
        return config('googlerecaptchav3.background_mode');
    }
}
