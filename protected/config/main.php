<?php

require_once(dirname(__FILE__) . '/local.conf');

return array(
    'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => 'Armory Lite',
    'language'       => 'ru',
    'sourceLanguage' => 'en',
    // preloading 'log' component
    'preload'        => array(
        #'log',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.helpers.*',
        'application.components.*',
    ),
    // application components
    'components' => array(
        'db'     => array(
            'connectionString'   => 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            //'emulatePrepare'   => true,
            'username'           => DB_USER,
            'password'           => DB_PASS,
            'charset'            => 'utf8',
            'tablePrefix'        => '',
            'schemaCachingDuration' => 3600 * 24 * 365,
            //'enableProfiling'    => YII_DEBUG,
            //'enableParamLogging' => YII_DEBUG,
        ),
        'db_chars' => array(
            'connectionString'   => 'mysql:host=' . DB_CHARS_HOST . ';dbname=' . DB_CHARS_NAME,
            //'emulatePrepare'   => true,
            'username'           => DB_CHARS_USER,
            'password'           => DB_CHARS_PASS,
            'charset'            => 'utf8',
            'tablePrefix'        => '',
            'schemaCachingDuration' => 3600 * 24 * 365,
            'class'            => 'CDbConnection',
            //'enableProfiling'    => YII_DEBUG,
            //'enableParamLogging' => YII_DEBUG,

        ),
        'db_world' => array(
            'connectionString'   => 'mysql:host=' . DB_WORLD_HOST . ';dbname=' . DB_WORLD_NAME,
            //'emulatePrepare'   => true,
            'username'           => DB_WORLD_USER,
            'password'           => DB_WORLD_PASS,
            'charset'            => 'utf8',
            'tablePrefix'        => '',
            'schemaCachingDuration' => 3600 * 24 * 365,
            'class'            => 'CDbConnection'          // DO NOT FORGET THIS!
        ),
        'cache'                 => array(
            'class' => 'system.caching.CDummyCache',
        ),
        /*'log'   => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'     => 'CProfileLogRoute',
                ),
            ),
        ),*/
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<_c:\w+>/<id:\d+>' => '<_c>/view',
                '<_c:character|guild>/<_a:\w+>/<realm>/<name:\w+>' => '<_c>/<_a>',
                array('<_c>/<_a>', 'pattern' => '<_c:statistic>/<realm>/<_a:\w+>', 'caseSensitive' => false),
            ),
            'showScriptName' => false,
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
