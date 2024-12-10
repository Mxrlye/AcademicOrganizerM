<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'ACADEMIC ORGANIZER', // Nombre de la aplicación
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'], // Componentes que se cargan al inicio
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'Marlene', // Clave secreta para validar cookies
            'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
 'mailer' => [
    'class' => \yii\symfonymailer\Mailer::class,
    'viewPath' => '@app/mail',
    'useFileTransport' => false,
    'transport' => [
        'dsn' => 'smtp://academicorganizerm@gmail.com:ypoaxlgresudazqj@smtp.gmail.com:587',
    ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'subirarchivo' => 'site/subirarchivo',
                'carpetas' => 'site/carpetas',
                'crear-carpeta/<nombre>' => 'site/crear-carpeta',
                'eliminar-archivo/<nombre>' => 'site/eliminar-archivo',
                'registro' => 'site/registro',
                'login' => 'site/login',
                'site/subircarpeta' => 'site/subircarpeta',
                'site/delete-event' => 'site/delete-event',

            ],
        ],
    ],
    'params' => $params,
];

// Configuración para el entorno de desarrollo
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

