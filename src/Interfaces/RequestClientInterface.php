<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Interfaces;

interface RequestClientInterface
{
    /**
     * @param $url
     * @param $body
     * @param  array  $options
     * @return mixed
     */
    public function post($url, $body, $options = []);
}
