<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3;

use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;

class GoogleReCaptchaV3
{
    private $service;
    private $defaultTemplate = 'GoogleReCaptchaV3::googlerecaptchav3.template';

    public function __construct(GoogleReCaptchaV3Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param $mappers
     * @return array
     */
    public function prepareViewData($mappers)
    {
        $prepareData = [];
        foreach ($mappers as $id => $action) {
            $prepareData[$action][] = $id;
        }

        $data = [
            'publicKey' => $this->getConfig()->getSiteKey(),
            'mappers' => $prepareData,
            'inline' => $this->getConfig()->isInline(),
            'language' => $this->getConfig()->getLanguage(),
        ];

        return $data;
    }

    /**
     * @param $mappers
     * @return \Illuminate\Contracts\View\View|null
     */
    public function render($mappers)
    {
        if (! $this->getConfig()->isServiceEnabled()) {
            return;
        }
        $data = $this->prepareViewData($mappers);

        return app('view')->make($this->getView(), $data);
    }

    /**
     * @return mixed|string
     */
    protected function getView()
    {
        return $this->defaultTemplate;
    }

    /**
     * @param $response
     * @param null $ip
     * @return GoogleReCaptchaV3Response
     */
    public function verifyResponse($response, $ip = null)
    {
        return $this->service->verifyResponse($response, $ip);
    }

    /**
     * @return ReCaptchaConfigV3Interface
     */
    public function getConfig()
    {
        return $this->service->getConfig();
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setAction($value = null)
    {
        $this->service->setAction($value);

        return $this;
    }


    /**
     * @param string|null $value
     * @return $this
     */
    public function setScore($value = null)
    {
        $this->service->setScore($value);

        return $this;
    }
}
