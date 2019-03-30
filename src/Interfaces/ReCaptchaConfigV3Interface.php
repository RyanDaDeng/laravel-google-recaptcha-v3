<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Interfaces;

interface ReCaptchaConfigV3Interface
{
    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @return bool
     */
    public function isServiceEnabled();

    /**
     * @return bool
     */
    public function isScoreEnabled();

    /**
     * @return string
     */
    public function getSecretKey();

    /**
     * @return string
     */
    public function getSiteKey();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return array
     */
    public function getSetting();

    /**
     * @return string
     */
    public function getSiteVerifyUrl();

    /**
     * @return string
     */
    public function getHostName();

    /**
     * @return bool
     */
    public function isInline();

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @return array
     */
    public function getSkipIps();

    /**
     * @return bool
     */
    public function getBackgroundBadgeDisplay();

    /**
     * @return bool
     */
    public function shouldEnableBackgroundMode();

    /**
     * @return string
     */
    public function getApiJsUrl();
}
