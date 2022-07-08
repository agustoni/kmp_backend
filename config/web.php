<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'assetManager' => [
            // override bundles to use local project files :
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => ['jquery.min.js'],
                    'jsOptions' => [ 'position' => \yii\web\View::POS_END],
                ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'sourcePath' => '@app/web/css/bootstrap',
                    'css' => [
                        YII_ENV_DEV ? 'bootstrap.css' : 'bootstrap.min.css',
                    ],
                    'cssOptions'=>[
                        'rel'=> 'preload stylesheet',
                        'as'=>'style',
                        'onload'=>'this.onload=null;this.rel=\'stylesheet\'',
                    ]
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'sourcePath' => '@app/web/js/bootstrap',
                    'js' => [
                        YII_ENV_DEV ? 'bootstrap.js' : 'bootstrap.min.js',
                    ],
                    'jsOptions'=>[
                        'defer'=>'defer'
                    ]
                ],
                // 'yii\web\JqueryAsset' => [
                //     'sourcePath' => null,   // do not publish the bundle
                //     'basePath' => '@webroot',
                //     'baseUrl' => '@web',
                //     'js' => [
                //         'web/js/jquery2.2.4.js'
                //     ]
                // ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7t64d1HXHS7V52olnbyxAJriXcDBQTvy',
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
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
            ],
        ],
        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
        //  'admin/*',
        //  '*'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
