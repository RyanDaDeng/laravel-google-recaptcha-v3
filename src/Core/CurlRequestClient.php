<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/23
 * Time: 下午7:24.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Core;

use Illuminate\Support\Facades\Lang;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;

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
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (false === $response) {
            return '{"success": false, "error-codes": ["Curl Error Code: '.Lang::get(GoogleReCaptchaV3Response::ERROR_TIMEOUT).'"]}';
        }

        if ($httpCode !== 200) {
            return '{"success": false, "error-codes": ["Curl Error Code: '.$httpCode.'"]}';
        }

        curl_close($curl);

        return $response;
    }
}
