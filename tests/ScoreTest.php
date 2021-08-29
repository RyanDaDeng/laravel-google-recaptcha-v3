<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV3\Configurations\ReCaptchaConfigV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;

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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

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
                    'score_comparison' => false,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testScore7()
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
                    'action' => 'contact_us_test',
                    'threshold' => 0.91,
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->setScore(0.8)->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testScore11()
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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testScore8()
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
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->setScore(0.8)->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testScore12()
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
                    'threshold' => 0.6,
                    'score_comparison' => true,
                ],
            ]);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.7, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->setScore(0.8)->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
    }
}
