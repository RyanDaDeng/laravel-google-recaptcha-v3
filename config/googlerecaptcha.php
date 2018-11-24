<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Service
    |--------------------------------------------------------------------------
    | Type: bool
    |
    | This option is used to disable/enable the service
    |
    | Supported: true, false
    |
    */
    'is_service_enabled' => true,
    /*
    |--------------------------------------------------------------------------
    | Host Name
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA host name, https://www.google.com/recaptcha/admin
    |
    */
    'host_name' => 'ryandeng.test',
    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA credentials, https://www.google.com/recaptcha/admin
    |
    */
    'secret_key' => '',
    /*
    |--------------------------------------------------------------------------
    | Site Key
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA credentials, https://www.google.com/recaptcha/admin
    |
    */
    'site_key' => '',
    /*
    |--------------------------------------------------------------------------
    | Template
    |--------------------------------------------------------------------------
    | Type: string
    | Template path, if your template locate at resources/views/template/test.blade.php
    | your value should be template.test
    |
    */
    'template' => 'googlerecaptcha.googlerecaptcha',
    /*
    |--------------------------------------------------------------------------
    | Score Comparision
    |--------------------------------------------------------------------------
    | Type: bool
    | If you enable it, the package will do score comparision from your score_setting
    */
    'is_score_enabled' => true,
    /*
    |--------------------------------------------------------------------------
    | Score Setting
    |--------------------------------------------------------------------------
    | Type: array
    | Define your score threshold
    | action: Google reCAPTCHA required paramater
    | id: <input> id
    | threshold: score threshold
    | is_enabled: true/false, if this is true, the system will do score comparsion against your threshold for the action
    */
    'score_setting' => [
        [
            'action' => 'contact_us',
            'id' => 'contact_us_id',
            'threshold' => 0,
            'is_enabled' => false
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    | Used for request
    |
    */
    'options' => [
        'curl_timeout' => 1,
        'curl_verify' => 1,
    ],
    /*
    |--------------------------------------------------------------------------
    | Site Verify Url
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA API
    */
    'site_verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
];
