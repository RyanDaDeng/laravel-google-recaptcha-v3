<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3;

use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;
use TimeHunter\LaravelGoogleReCaptchaV3\Services\GoogleReCaptchaV3Service;

class GoogleReCaptchaV3
{
    private $service;
    private $defaultTemplate = 'GoogleReCaptchaV3::googlerecaptchav3.template';
    private $defaultFieldTemplate = 'GoogleReCaptchaV3::googlerecaptchav3.field';
    public static $hasAction = false;

    public static $collection = [];

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
            'apiJsUrl' => $this->getConfig()->getApiJsUrl(),
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function prepareData()
    {
        if (self::$hasAction) {
            return $this->prepareViewData(self::$collection);
        } else {
            return $this->prepareBackgroundViewData();
        }
    }

    /**
     * @return array
     */
    public function prepareBackgroundViewData()
    {
        return [
            'publicKey' => $this->getConfig()->getSiteKey(),
            'display' => $this->getConfig()->getBackgroundBadgeDisplay(),
            'language' => $this->getConfig()->getLanguage(),
            'apiJsUrl' => $this->getConfig()->getApiJsUrl(),
        ];
    }

    /**
     * @param  array  $params
     * @return \Illuminate\Contracts\View\View|mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function init(array $params = [])
    {
        if (! $this->getConfig()->isServiceEnabled()) {
            return;
        }
        $default = [
            'hasAction' => self::$hasAction,
            'backgroundMode' => $this->getConfig()->shouldEnableBackgroundMode(),
            'apiJsUrl' => $this->getConfig()->getApiJsUrl(),
        ];

        return app('view')->make($this->getView(), array_merge($this->prepareData(), $default, $params));
    }

    /**
     * @param $id
     * @param $action
     */
    public function renderOne($id, $action)
    {
        self::$hasAction = true;
        self::$collection[$id] = $action;
    }

    /**
     * @param $id
     * @param $action
     * @param  string  $class
     * @param  string  $style
     * @return \Illuminate\Contracts\View\View|mixed
     */
    public function renderField($id, $action, $class = '', $style = '')
    {
        self::$hasAction = true;
        self::$collection[$id] = $action;

        return app('view')->make($this->getFieldView(), ['id' => $id, 'class'=> $class, 'style' => $style]);
    }

    /**
     * @param $mappers
     */
    public function render($mappers)
    {
        self::$hasAction = true;
        foreach ($mappers as $id => $action) {
            self::$collection[$id] = $action;
        }
    }

    /**
     * @return mixed|string
     */
    protected function getView()
    {
        return $this->defaultTemplate;
    }

    /**
     * @return mixed|string
     */
    protected function getFieldView()
    {
        return $this->defaultFieldTemplate;
    }

    /**
     * @param $response
     * @param  null  $ip
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
     * @param  string|null  $value
     * @return $this
     */
    public function setAction($value = null)
    {
        $this->service->setAction($value);

        return $this;
    }

    /**
     * @param  string|null  $value
     * @return $this
     */
    public function setScore($value = null)
    {
        $this->service->setScore($value);

        return $this;
    }
}
