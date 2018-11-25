<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/23
 * Time: 下午7:24
 */

namespace TimeHunter\LaravelGoogleCaptchaV3\Core;


use TimeHunter\LaravelGoogleCaptchaV3\Interfaces\RequestClientInterface;

class CurlRequestClient implements RequestClientInterface
{

    public function post($url, $body, $options = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            http_build_query($body));

        $response = curl_exec($curl);

        if (false === $response) {
            app('log')->error('[Recaptcha] CURL error: ' . curl_error($curl));
        }
        curl_close($curl);

        return $response;
    }
}