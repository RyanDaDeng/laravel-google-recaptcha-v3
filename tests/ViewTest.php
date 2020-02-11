<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV3\Configurations\ReCaptchaConfigV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;

class ViewTest extends TestCase
{
    public function testView()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $service->renderOne('contact_us_id66', 'contact_us');
        $data = $service->init();
        $this->assertEquals(null, $data);
    }

    public function testView1()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $service->renderOne('contact_us_id77', 'contact_us');
        $service->render(['contact_us_id88'=> 'contact_us']);
        $data = $service::$collection;
        $this->assertEquals('contact_us', $data['contact_us_id77']);
        $this->assertEquals('contact_us', $data['contact_us_id88']);
    }

    public function testView2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSiteKey')
            ->willReturn('test1');

        $configStub->method('isInline')
            ->willReturn(false);

        $configStub->method('getLanguage')
            ->willReturn('en');

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);

        $data = $service->prepareViewData(['contact_us_id' => 'contact_us']);
        $this->assertEquals('test1', $data['publicKey']);
        $this->assertEquals('contact_us_id', $data['mappers']['contact_us'][0]);
        $this->assertEquals(false, $data['inline']);
        $this->assertEquals('en', $data['language']);
    }

    public function testView4()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV3::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSiteKey')
            ->willReturn('test1');

        $configStub->method('isInline')
            ->willReturn(false);

        $configStub->method('getLanguage')
            ->willReturn('en');

        $configStub->method('getBackgroundBadgeDisplay')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV3Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV3($_service);
        GoogleReCaptchaV3::$hasAction = false;
        $data = $service->prepareData();
        $this->assertEquals(false, $data['display']);
        $this->assertEquals('test1', $data['publicKey']);
    }
}
