<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleCaptchaV3\Configurations\ReCaptchaConfigV3;


class ScoreTest extends TestCase
{


    public function testScore1()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(true);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us',
                    'threshold' => 1,
                    'score_comparision' => true
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD, $response->getMessage());
    }



    public function testScore2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(false);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us',
                    'threshold' => 1,
                    'score_comparision' => true
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }




    public function testScore3()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(true);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us',
                    'threshold' => 1,
                    'score_comparision' => false
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }




    public function testScore4()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(true);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us',
                    'threshold' => 0.9,
                    'score_comparision' => true
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }


    public function testScore5()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(true);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us',
                    'threshold' => 0.91,
                    'score_comparision' => true
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD, $response->getMessage());
    }



    public function testScore6()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('isScoreEnabled')
            ->willReturn(true);

        $configStub->method('getSetting')
            ->willReturn([
                [
                    'action' => 'contact_us_test',
                    'threshold' => 0.91,
                    'score_comparision' => true
                ]
            ]);


        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }

}
