<?php

return [
    'is_service_enabled' => true,
    'host_name' => 'ryandeng.test',
    'secret_key' => '6Lez2HcUAAAAAIvmnukbhNLUAighVP6AuPcOFXT2',
    'curl_timeout' => 1,
    'curl_verify' => false,
    'template' => 'GoogleReCaptcha::googlerecaptcha.googlerecaptcha',
    'site_key' => '6Lez2HcUAAAAAJPDe-qVi5H8G5FB049E5mrljqt4',
    'options' => [
        'curl_timeout' => 1,
        'curl_verify' => 1,
    ],
    'is_score_enabled' => true,
    'score_setting' => [
        [
            'action' => 'a',
            'id' => 'cccc',
            'threshold' => 0.2,
            'is_enabled' => false
        ],
        [
            'action' => 'c',
            'id' => 'ddd',
            'threshold' => 0.1,
            'is_enabled' => true
        ],
    ],
    'site_verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
];
