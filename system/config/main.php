<?php

    // uncomment the following to define a path alias
    // Yii::setPathOfAlias('local','path/to/local-folder');

    return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Shiny Adventure',

        'preload'=>array('log'),
        'defaultController' => 'main',

        'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.form.*',
            // extended yii's RBAC
            'application.components.ARBAC.*',
        ),

        'modules'=>array(
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'pharazon',
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters'=>array('127.0.0.1','::1', '*'),
            ),
        ),

        'components'=>array(
            'user'=>array(
                'allowAutoLogin'=>true,
                'class' => 'AWebUser',
            ),
            'authManager'=>array(
                'class'=>'AAuthManager',
                'connectionID'=>'db',
                'itemTable'=>'{{auth_item}}',
                'assignmentTable'=>'{{auth_assignment}}',
                'itemChildTable'=>'{{auth_item_child}}',
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),
            'errorHandler'=>array(
                'errorAction'=>'main/error',
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                    ),
                    // uncomment the following to show log messages on web pages
                    /*
                    array(
                        'class'=>'CWebLogRoute',
                    ),
                    */
                ),
            ),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(
            'adminEmail'=>'jakub@mrowiec.org',
            'loginPage' => '/main/login',
            'dashboardPage' => '/user/dashboard',
        ),
    );
