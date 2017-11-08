<?php

$config = [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'generators\model\Generator',
                'templates' => [
                    'scarface' => '@root/generators/model/scarface',
                    'scarface-trait' => '@root/generators/model/scarface-trait',
                ]
            ]
        ]
    ],
];

return $config;