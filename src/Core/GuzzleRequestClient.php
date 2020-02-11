<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/23
 * Time: 下午7:24.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Lang;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;

class GuzzleRequestClient implements RequestClientInterface
{
    public function post($url, $body, $options = [])
    {
        $client = new Client();
        try {
            $response = $client->post($url, [
                'form_params' => $body,
            ]);

            return $response->getBody();
        } catch (ClientException $e) {
            return '{"success": false, "error-codes": ["Guzzle Client Error Code: '.$e->getCode().'"]}';
        } catch (ConnectException $e) {
            return '{"success": false, "error-codes": ["Guzzle Client Error Code: '.Lang::get(GoogleReCaptchaV3Response::ERROR_TIMEOUT).'"]}';
        }
    }
}
