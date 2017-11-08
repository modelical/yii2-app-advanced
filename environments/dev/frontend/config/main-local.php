<?php

$config = [
    'homeUrl' => '/<base-path>',
    'components' => [
        'request' => [
            'baseUrl' => '/<base-path>',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
    ];
}

return $config;
