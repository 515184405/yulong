<?php
$params = array_merge(
    require __DIR__ . '/../../phone/config/params.php',
    require __DIR__ . '/../../phone/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-photolive',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'photolive\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-photolive',
        ],
        'user' => [
            'identityClass' => 'photolive\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-photolive', 'httpOnly' => true],
            'loginUrl'=>array('site/login'), //设置为登录时跳的路径
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-photolive',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
