<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/23
 * Time: 下午7:24
 */

namespace RyanDeng\GoogleReCaptcha\Core;


use GuzzleHttp\Exception\ClientException;
use RyanDeng\GoogleReCaptcha\Interfaces\RequestClientInterface;
use GuzzleHttp\Client;


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
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            app('log')->error('[Recaptcha] Guzzle error: ' . $responseBodyAsString);
            return $responseBodyAsString;
        }
    }
}