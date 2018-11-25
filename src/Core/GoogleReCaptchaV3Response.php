<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/22
 * Time: 下午11:46
 */

namespace TimeHunter\LaravelGoogleCaptchaV3\Core;


use Carbon\Carbon;

class GoogleReCaptchaV3Response
{
    protected $success;
    protected $score;
    protected $action;
    protected $challengeTs;
    protected $hostname;
    protected $errorCodes = [];
    protected $ip;
    protected $message;

    public function __construct($data, $ip, $message = '')
    {
        $this->success = isset($data['success']) ? $data['success'] : false;
        $this->score = isset($data['score']) ? $data['score'] : 0;
        $this->action = isset($data['action']) ? $data['action'] : '';
        $this->challengeTs = isset($data['challenge_ts']) ? $data['challenge_ts'] : null;
        $this->hostname = isset($data['hostname']) ? $data['hostname'] : '';
        $this->errorCodes = isset($data['error-codes']) ? $data['error-codes'] : [];
        $this->ip = $ip;
        $this->message = $this->errorCodes ? $this->errorCodes[0] : $message;
    }

    /**
     * @param bool $value
     */
    public function setSuccess(bool $value)
    {
        $this->success = $value;
    }


    /**
     * @param string $value
     */
    public function setMessage(string $value)
    {
        $this->message = $value;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return Carbon
     */
    public function getChallengeTs()
    {
        return Carbon::parse($this->challengeTs);
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'success' => $this->success,
            'ip' => $this->ip,
            'score' => $this->score,
            'action' => $this->action,
            'challengeTs' => $this->challengeTs,
            'hostname' => $this->hostname,
            'errorCodes' => $this->errorCodes,
            'message' => $this->message
        ];
    }

}