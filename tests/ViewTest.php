<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleCaptchaV3\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleCaptchaV3\Configurations\ReCaptchaConfigV3;


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

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $data = $service->render(['contact_us_id' => 'contact_us']);
        $this->assertEquals(null, $data);
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

        $service = new GoogleReCaptchaV3($configStub, $clientStub);

        $data = $service->prepareViewData(['contact_us_id' => 'contact_us']);
        $this->assertEquals('test1', $data['publicKey']);
        $this->assertEquals('contact_us_id', $data['mappers']['contact_us'][0]);
        $this->assertEquals(false, $data['inline']);
        $this->assertEquals('en', $data['language']);
    }


}
