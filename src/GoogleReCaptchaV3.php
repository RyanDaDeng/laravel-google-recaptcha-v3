<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM
 */

namespace TimeHunter\LaravelGoogleCaptchaV3;

use TimeHunter\LaravelGoogleCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;
use TimeHunter\LaravelGoogleCaptchaV3\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleCaptchaV3\Core\GoogleReCaptchaV3Response;

class GoogleReCaptchaV3
{
    private $config;
    private $requestClient;
    private $action;
    private $defaultTemplate = 'GoogleReCaptchaV3::googlerecaptchav3.template';
    private $request;

    public function __construct(ReCaptchaConfigV3Interface $config, RequestClientInterface $requestClient)
    {
        $this->config = $config;
        $this->requestClient = $requestClient;
        $this->request = app('request');

    }


    /**
     * @param $mappers
     * @return mixed
     */
    public function render($mappers)
    {
        $prepareData = [];
        foreach ($mappers as $id => $action) {
            $prepareData[$action][] = $id;
        }

        return app('view')->make(
            $this->getView(),
            [
                'publicKey' => $this->getConfig()->getSiteKey(),
                'mappers' => $prepareData,
                'inline' => $this->config->isInline(),
                'language' => $this->config->getLanguage()
            ]
        );
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
     * @return GoogleReCaptchaV3Response
     */
    public function verifyResponse($response)
    {

        $ip = $this->request->getClientIp();
        if (!$this->config->isServiceEnabled()) {
            $res = new GoogleReCaptchaV3Response([], $ip);
            $res->setSuccess(true);
            return $res;
        }

        if (empty($response)) {
            $res = new GoogleReCaptchaV3Response([], $ip, 'Missing input response.');
            $res->setSuccess(false);
            return $res;
        }

        $verifiedResponse = $this->requestClient->post(
            $this->config->getSiteVerifyUrl(),
            [
                'secret' => $this->config->getSecretKey(),
                'remoteip' => $ip,
                'response' => $response,
            ],
            $this->config->getOptions()
        );

        if (is_null($verifiedResponse) || empty($verifiedResponse)) {
            return new GoogleReCaptchaV3Response([], $ip, 'Unable to verify.');
        }

        $decodedResponse = json_decode($verifiedResponse, true);
        $rawResponse = new GoogleReCaptchaV3Response($decodedResponse, $ip);

        if ($rawResponse->isSuccess() === false) {
            return $rawResponse;
        }

        if (!empty($this->config->getHostName()) && strcasecmp($this->config->getHostName(), $rawResponse->getHostname()) !== 0) {
            $rawResponse->setMessage('Hostname does not match.');
            $rawResponse->setSuccess(false);
            return $rawResponse;
        }

        if (isset($this->action) && strcasecmp($this->action, $rawResponse->getAction()) !== 0) {
            $rawResponse->setMessage('Action does not match.');
            $rawResponse->setSuccess(false);
            return $rawResponse;
        }

        if ($this->getConfig()->isScoreEnabled()) {
            $count = collect($this->getConfig()->getSetting())
                ->where('action', '=', $rawResponse->getAction())
                ->where('score_comparision', '=', true)
                ->where('threshold', '>', $rawResponse->getScore())
                ->count();
            if ($count > 0) {
                $rawResponse->setSuccess(false);
                $rawResponse->setMessage('Score does not meet threshold.');
                return $rawResponse;
            }
        }
        $rawResponse->setSuccess(true);
        $rawResponse->setMessage('Successfully passed.');
        return $rawResponse;
    }

    /**
     * @return ReCaptchaConfigV3Interface
     */
    public function getConfig()
    {
        return $this->config;

    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setAction(string $value = null)
    {
        $this->action = $value;
        return $this;
    }

}