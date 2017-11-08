<?php

$config = [
    'homeUrl' => '/<base-path>/backend',
    'components' => [
        'request' => [
            'baseUrl' => '/<base-path>/backend',
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

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
        'generators' => [
            'apicontroller' => [
                'class' => '\common\generators\apicontroller\Generator',
                'templates' => [
                    'api' => '@common/generators/apicontroller/api',
                ]
            ],
            'apimodel' => [
                'class' => '\common\generators\apimodel\Generator',
                'templates' => [
                    'api' => '@common/generators/apimodel/api',
                ]
            ],
            'basemodel' => [
                'class' => '\common\generators\basemodel\Generator',
                'templates' => [
                    'common' => '@common/generators/basemodel/common',
                ]
            ]
        ]
    ];
}

return $config;
