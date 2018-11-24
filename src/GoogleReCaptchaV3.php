<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM
 */

namespace RyanDeng\GoogleReCaptcha;

use RyanDeng\GoogleReCaptcha\Interfaces\ReCaptchaConfigV3Interface;
use RyanDeng\GoogleReCaptcha\Interfaces\RequestClientInterface;
use RyanDeng\GoogleReCaptcha\Core\GoogleReCaptchaV3Response;

class GoogleReCaptchaV3
{
    private $config;
    private $requestClient;
    private $action;
    private $defaultView = 'GoogleReCaptchaV3::googlerecaptcha.googlerecaptchav3';

    public function __construct(ReCaptchaConfigV3Interface $config, RequestClientInterface $requestClient)
    {
        $this->config = $config;
        $this->requestClient = $requestClient;
    }

    /**
     * @param mixed ...$actions
     * @return mixed
     */
    public function render(...$actions)
    {
        if ($this->config->isServiceEnabled() === false) {
            return null;
        }

        $mapping = collect($this->config->getScoreSetting())
            ->whereIn('action', $actions)
            ->pluck('id', 'action')
            ->toArray();

        $data = [
            'publicKey' => value($this->config->getSiteKey()),
            'rows' => $mapping
        ];

        $view = $this->getView();

        return app('view')->make($view, $data);
    }

    /**
     * @return mixed|string
     */
    protected function getView()
    {
        $configTemplate = $this->config->getTemplate();

        if (!empty($configTemplate)) {
            $this->defaultView = $configTemplate;
        }
        return $this->defaultView;
    }

    /**
     * @param $response
     * @param null $ip
     * @return GoogleReCaptchaV3Response
     */
    public function verifyResponse($response, $ip = null)
    {

        if (!$this->config->isServiceEnabled()) {
            $res = new GoogleReCaptchaV3Response([], $ip);
            $res->setSuccess(true);
            return $res;
        }

        if (empty($response)) {
            return new GoogleReCaptchaV3Response([], $ip, 'Missing input response.');
        }

        $verifiedResponse = $this->requestClient->post(
            $this->config->getSiteVerifyUrl(),
            [
                'secret' => $this->config->getSecretKey(),
                'remoteip' => $ip,
                'response' => $response,
            ],
            [
                'curl_timeout' => $this->config->getCurlTimeout(),
                'curl_verify' => $this->config->getCurlVerify(),
            ]
        );

        if (is_null($verifiedResponse) || empty($verifiedResponse)) {
            return new GoogleReCaptchaV3Response([], $ip, 'Unable to verify.');
        }

        $decodedResponse = json_decode($verifiedResponse, true);
        $rawResponse = new GoogleReCaptchaV3Response($decodedResponse, $ip);

        if ($rawResponse->isSuccess() === false) {
            return $rawResponse;
        }

        if (strcasecmp($this->config->getHostName(), $rawResponse->getHostname()) !== 0) {
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
            $count = collect($this->getConfig()->getScoreSetting())
                ->where('action', '=', $rawResponse->getAction())
                ->where('is_enabled', '=', true)
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