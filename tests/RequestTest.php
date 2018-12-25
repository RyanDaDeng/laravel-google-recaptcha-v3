<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleCaptchaV3\Core\CurlRequestClient;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GuzzleRequestClient;


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

        $response = new GoogleReCaptchaV3Response(json_decode($response,1), null, '');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(2, count($response->getErrorCodes()));

    }



    public function testGuzzleRequest()
    {

        $client = new GuzzleRequestClient();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => 'test',
            'remoteip' => null,
            'response' => 'test',
        ]);

        $response = new GoogleReCaptchaV3Response(json_decode($response,1), null, '');
        $this->assertEquals(false, $response->toArray()['success']);
        $this->assertEquals(2, count($response->getErrorCodes()));

    }


}
