<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV3\Services;

use Illuminate\Support\Facades\Lang;
use TimeHunter\LaravelGoogleReCaptchaV3\Core\GoogleReCaptchaV3Response;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface;
use TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface;

class GoogleReCaptchaV3Service
{
    private $config;
    private $requestClient;
    private $action;
    private $score;

    public function __construct(ReCaptchaConfigV3Interface $config, RequestClientInterface $requestClient)
    {
        $this->config = $config;
        $this->requestClient = $requestClient;
    }

    /**
     * @param $ip
     * @return bool
     */
    public function ifInSkippedIps($ip)
    {
        $ips = $this->config->getSkipIps();

        return in_array($ip, $ips);
    }

    /**
     * @param $response
     * @param  null  $ip
     * @return GoogleReCaptchaV3Response
     */
    public function verifyResponse($response, $ip = null)
    {
        if (! $this->config->isServiceEnabled() || ($ip && $this->ifInSkippedIps($ip)) === true) {
            $res = new GoogleReCaptchaV3Response([], $ip);
            $res->setSuccess(true);

            return $res;
        }

        if (empty($response)) {
            $res = new GoogleReCaptchaV3Response([], $ip, Lang::get(GoogleReCaptchaV3Response::ERROR_MISSING_INPUT));
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
            return new GoogleReCaptchaV3Response([], $ip, Lang::get(GoogleReCaptchaV3Response::ERROR_UNABLE_TO_VERIFY));
        }

        $decodedResponse = json_decode($verifiedResponse, true);
        $rawResponse = new GoogleReCaptchaV3Response($decodedResponse, $ip);

        if ($rawResponse->getMessage() === 'timeout-or-duplicate') {
            $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::TIMEOUT_OR_DUPLICATE));

            return $rawResponse;
        }

        if ($rawResponse->isSuccess() === false) {
            return $rawResponse;
        }

        if (! empty($this->config->getHostName()) && strcasecmp($this->config->getHostName(), $rawResponse->getHostname()) !== 0) {
            $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::ERROR_HOSTNAME));
            $rawResponse->setSuccess(false);

            return $rawResponse;
        }

        if (isset($this->action) && strcasecmp($this->action, $rawResponse->getAction()) !== 0) {
            $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::ERROR_ACTION));
            $rawResponse->setSuccess(false);

            return $rawResponse;
        }

        if (isset($this->score) && $this->score > $rawResponse->getScore()) {
            $rawResponse->setSuccess(false);
            $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD));

            return $rawResponse;
        } else {
            if ($this->getConfig()->isScoreEnabled()) {
                $count = collect($this->getConfig()->getSetting())
                    ->where('action', '=', $rawResponse->getAction())
                    ->where('score_comparison', '=', true)
                    ->where('threshold', '>', $rawResponse->getScore())
                    ->count();

                $oldCount = collect($this->getConfig()->getSetting())
                    ->where('action', '=', $rawResponse->getAction())
                    ->where('score_comparision', '=', true)
                    ->where('threshold', '>', $rawResponse->getScore())
                    ->count();

                if ($count > 0 || $oldCount > 0) {
                    $rawResponse->setSuccess(false);
                    $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::ERROR_SCORE_THRESHOLD));

                    return $rawResponse;
                }
            }
        }

        $rawResponse->setSuccess(true);
        $rawResponse->setMessage(Lang::get(GoogleReCaptchaV3Response::SUCCESS));

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
     * @param  string|null  $value
     * @return $this
     */
    public function setAction($value = null)
    {
        $this->action = $value;

        return $this;
    }

    /**
     * @param  string|null  $value
     * @return $this
     */
    public function setScore($value = null)
    {
        $this->score = $value;

        return $this;
    }
}
