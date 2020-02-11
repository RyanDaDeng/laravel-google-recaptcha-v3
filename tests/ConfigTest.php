<?php

namespace TimeHunter\Tests;

use Illuminate\Support\Facades\Lang;
use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV3\Configurations\ReCaptchaConfigV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;

class ConfigTest extends TestCase
{
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_MISSING_INPUT)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_MISSING_INPUT);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_UNABLE_TO_VERIFY)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_UNABLE_TO_VERIFY);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_HOSTNAME)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_HOSTNAME);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_ACTION)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_ACTION);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD)
            ->andReturn(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD);
        Lang::shouldReceive('get')
            ->with(GoogleReCaptchaV3Response::SUCCESS)
            ->andReturn(GoogleReCaptchaV3Response::SUCCESS);
    }

    public function testServiceDisabled()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn(false);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testMissingInput()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn(false);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse(null);
        $this->assertEquals(false, $response->isSuccess());

        $response = $service->verifyResponse('');

        $this->assertEquals(false, $response->isSuccess());
    }

    public function testEmptyResponse()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = null;

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse(null);
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testFalseResponse()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": false, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testHostName1()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $configStub->method('getHostName')
            ->willReturn('wrong.test');

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');

        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(GoogleReCaptchaV3Response::ERROR_HOSTNAME, $response->getMessage());
    }

    public function testHostName2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $configStub->method('getHostName')
            ->willReturn('');

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');

        $this->assertEquals(true, $response->isSuccess());
    }

    public function testAction()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);
        $service->setAction('contact_us_wrong');

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(GoogleReCaptchaV3Response::ERROR_ACTION, $response->getMessage());
    }

    public function testActionRight()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);
        $service->setAction('contact_us');

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testActionSkip()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testIpSkip1()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSkipIps')
            ->willReturn(['1.1.1.1']);

        $testJson = '{ "success": false, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response', '1.1.1.1');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testIpSkip2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSkipIps')
            ->willReturn(['1.1.1.1']);

        $testJson = '{ "success": false, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test", "score": 0.9, "action": "contact_us" }';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $response = $service->verifyResponse('test response', '1.1.1.2');
        $this->assertEquals(false, $response->isSuccess());
    }
}
