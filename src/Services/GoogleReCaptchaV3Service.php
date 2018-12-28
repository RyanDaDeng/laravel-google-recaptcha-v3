<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Services;

use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;

class GoogleReCaptchaV3Service
{
    private $config;
    private $requestClient;
    private $action;

    public function __construct(ReCaptchaConfigV3Interface $config, RequestClientInterface $requestClient)
    {
        $this->config = $config;
        $this->requestClient = $requestClient;
    }

    /**
     * @param $response
     * @param null $ip
     * @return GoogleReCaptchaV3Response
     */
    public function verifyResponse($response, $ip = null)
    {
        if (! $this->config->isServiceEnabled()) {
            $res = new GoogleReCaptchaV3Response([], $ip);
            $res->setSuccess(true);

            return $res;
        }

        if (empty($response)) {
            $res = new GoogleReCaptchaV3Response([], $ip, GoogleReCaptchaV3Response::MISSING_INPUT_ERROR);
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
            return new GoogleReCaptchaV3Response([], $ip, GoogleReCaptchaV3Response::ERROR_UNABLE_TO_VERIFY);
        }

        $decodedResponse = json_decode($verifiedResponse, true);
        $rawResponse = new GoogleReCaptchaV3Response($decodedResponse, $ip);

        if ($rawResponse->isSuccess() === false) {
            return $rawResponse;
        }

        if (! empty($this->config->getHostName()) && strcasecmp($this->config->getHostName(), $rawResponse->getHostname()) !== 0) {
            $rawResponse->setMessage(GoogleReCaptchaV3Response::ERROR_HOSTNAME);
            $rawResponse->setSuccess(false);

            return $rawResponse;
        }

        if (isset($this->action) && strcasecmp($this->action, $rawResponse->getAction()) !== 0) {
            $rawResponse->setMessage(GoogleReCaptchaV3Response::ERROR_ACTION);
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
                $rawResponse->setMessage(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD);

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
