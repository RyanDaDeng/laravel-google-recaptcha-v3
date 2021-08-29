<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\CurlRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;

class RequestTest extends TestCase
{
    public function testCurlRequest()
    {
        $client = new CurlRequestClient();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => 'test',
            'remoteip' => null,
            'response' => 'test',
        ]);

        $response = new GoogleReCaptchaV3Response(json_decode($response, 1), null, '');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(1, count($response->getErrorCodes()));
    }

    public function testCurlRequest2()
    {
        $client = new CurlRequestClient();

        $response = $client->post('https://www.google.com/recaptcha/api/siteve11rify', [
            'secret' => 'test',
            'remoteip' => null,
            'response' => 'test',
        ]);

        $response = new GoogleReCaptchaV3Response(json_decode($response, 1), null, '');
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testGuzzleRequest()
    {
        $client = new GuzzleRequestClient();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => 'test',
            'remoteip' => null,
            'response' => 'test',
        ]);

        $response = new GoogleReCaptchaV3Response(json_decode($response, 1), null, '');
        $this->assertEquals(false, $response->toArray()['success']);
        $this->assertEquals(1, count($response->getErrorCodes()));
    }

    public function testGuzzleRequest2()
    {
        $client = new GuzzleRequestClient();

        $response = $client->post('https://www.google.com/recaptcha/api/sitev111erify', [
            'secret' => 'test',
            'remoteip' => null,
            'response' => 'test',
        ]);

        $response = new GoogleReCaptchaV3Response(json_decode($response, 1), null, '');
        $this->assertEquals(false, $response->toArray()['success']);
    }
}
