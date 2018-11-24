<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM
 */

namespace RyanDeng\GoogleReCaptcha\Interfaces;


interface ReCaptchaConfigV3Interface
{

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
    public function getTemplate();

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
}