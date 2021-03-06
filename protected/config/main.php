<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),
    
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
    
    'aliases' => array(
        'xupload' => 'ext.xupload'
    ),
    
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
        'cache'=>array(
            'class' => 'system.caching.CFileCache',		
        ),
        
        // uncomment the following to enable URLs in path-format
		'urlManager'=>array(
            'showScriptName'=>false,            
			'urlFormat'=>'path',
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                'admin'=>'admin/index',
                'admin/<action:\w+>'=>'admin/<action>',
                'site/<action:\w+>'=>'site/<action>',
                '<product>' => 'product/index/<product>',
                '<product:\w+>/<alias:\w+>' => 'article/index',
			),
		),
		
		'db'=>IS_PROD ? array(
            'connectionString' => 'mysql:host=mysql306.1gb.ua;dbname=gbua_ad_courses',
            'emulatePrepare' => true,
            'username' => 'gbua_ad_courses',
            'password' => '02fd65f43234',
            'charset' => 'utf8',
		) : array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=gbua_ad_courses',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
        
        'clientScript'=>array(
            'packages'=>array(
                /*'jquery'=>array(
                    'baseUrl'=>'/js/',
                    'js'=>array('jquery-2.1.1.min.js'),
                ),*/                             
            ),
        ),        
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);