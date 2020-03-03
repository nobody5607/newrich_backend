<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'name'=>'APP',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'th-TH',
    'timeZone' => 'Asia/Bangkok',
    'bootstrap' => [
        'log',
        'backend\components\AppComponent',
        [ 
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['en-US', 'th-TH'], //กำหนดรายการภาษาที่ support หรือใช้ได้
        ]
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '824540648022199',
                    'clientSecret' => '808e14b820c9adac18338dacd0883240',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@backend/themes/adminlte/views',
//                   // '@dektrium/user/views' => '@app/views/user'
//                ]
//            ]
//        ],
        
        'session' => [ 
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
        
        
 
         
    ],
    'modules'=>[

        'api' => [
            'class' => 'backend\modules\api\Module',
        ],

        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
        'gridviewKrajee' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
        'core' => [
            'class' => 'backend\modules\core\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@app/views/layouts/main.php',
            'controllerMap' => [
                'role'=>'common\modules\admin\controllers\RoleController',
                'user' => 'common\modules\admin\controllers\AdminController',
                'assignment' => [
                    'class' => 'common\modules\admin\controllers\AssignmentController',
                    'userClassName' => 'dektrium\user\models\User', 
                ]
            ],
            
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => FALSE,
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],//admin
            'modelMap' => [
                'User' => 'common\modules\user\models\User',
                'Profile' => 'common\modules\user\models\Profile',
                'RegistrationForm' => 'common\modules\user\models\RegistrationForm',
                'RecoveryForm' =>'common\modules\user\models\RecoveryForm'
            ],
            
            'controllerMap' => [
                'admin' => 'common\modules\user\controllers\AdminController',
                'settings' => 'common\modules\user\controllers\SettingsController',
                'registration' => 'common\modules\user\controllers\RegistrationController',
                'security'=>'common\modules\user\controllers\SecurityController',
                'recovery'=>'common\modules\user\controllers\RecoveryController',
                
            ],
        ],
        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //module, controller, action ที่อนุญาตให้ทำงานโดยไม่ต้องผ่านการตรวจสอบสิทธิ์
//            'site/*',
            'user/registration/register',
            'user/recovery/request',
            'user/recovery/reset',
            'api/*',
            //'informations/index',
            //'admin/*',
        ]
    ],
    'params' => $params,
];
