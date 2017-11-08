<?php

$config = [
    'homeUrl' => '/<base-path>/api',
    'components' => [
        'request' => [
            'baseUrl' => '/<base-path>/api',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

return $config;
