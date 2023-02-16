<?php
$params = array_merge(
require __DIR__ . '/../../common/config/params.php',
require __DIR__ . '/../../common/config/params-local.php',
require __DIR__ . '/params.php',
require __DIR__ . '/params-local.php'
);

return [
'id' => 'app-backend',
'basePath' => dirname(__DIR__),
'controllerNamespace' => 'backend\controllers',
'bootstrap' => ['log'],
'modules' => [        'rbac' => [
    'class' => 'yii2mod\rbac\Module',
],
],


'components' => [
    'request' => [
        'csrfParam' => '_csrf-backend',
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
        'defaultRoles' => ['guest', 'user'],
    ],
    'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                'sourceLanguage' => 'en',
                'fileMap' => [
                    //'main' => 'main.php',
                ],
            ],
        ],
    ],
    'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
    'session' => [
        // this is the name of the session cookie used for login on the backend
        'name' => 'advanced-backend',
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

    // 'urlManager' => [
    //     'enablePrettyUrl' => true,
    //     'showScriptName' => false,
    //     'rules' => [
    //         ['class' => 'yii\rest\UrlRule', 'controller' => 'backend/controllers/entity', 'pluralize' => false],
    //         'entity/GetEntityData/<id:\d+>' => 'entity/GetEntityData'
    //     ],
    // ],

    // 'urlManager'        => [
    //     'enablePrettyUrl'     => true,          // untuk meng-enable pretty url (dari /index.php?r=site%2Findex menjadi /site/index)
    //     'showScriptName'      => false,
    //     'enableStrictParsing' => false,
    //     'suffix'              => '.html',       // untuk menambahkan suffix / akhira .html di semua URL
    //     'rules'               => [
    //         [
    //             'pattern' => 'entity',
    //             'route'   => 'entity/list',
    //             'suffix'  => '',
    //         ]
    //     ],
    // ],
],
'params' => $params,
];
