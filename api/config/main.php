<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log', 'oauth2'],
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'access_token',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'api\models\User',
            ],
            'grantTypes' => [
//                'client_credentials' => [
//                    'class' => 'OAuth2\GrantType\ClientCredentials',
//                    'allow_public_clients' => false
//                ],
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ],
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],  
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\User',
            'loginUrl' => null,
            'enableSession' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/user'],
                    //'patterns' => []
                ],
                //['class' => 'yii\rest\UrlRule', 'controller' => ['v2/user', 'v2/post']],
            ],
        ],
        'request' => [
            //'baseUrl' => '/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ]
    ],
    'params' => $params,
];
