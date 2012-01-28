<?php

return array(
    'basePath'       => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'           => 'Hyperion\'s Sandbox',
    //'language' => 'ru',
    'sourceLanguage' => 'en',
    // preloading 'log' component
    'preload'        => array(
        'log',
        'bootstrap',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.*',
        'ext.bootstrap.widgets.*',
    ),
    // application components
    'components' => array(
        'request' => array(
            'enableCsrfValidation'   => true,
            'enableCookieValidation' => true,
        ),
        'db'                     => array(
            'connectionString'      => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
            'emulatePrepare'        => true,
            'username'              => DB_USER,
            'password'              => DB_PASS,
            'charset'               => 'utf8',
            'tablePrefix'           => '',
        ),
        'db_world'              => array(
            'class'                 => 'CDbConnection',
            'connectionString'      => 'mysql:host='.DB_WORLD_HOST.';dbname='.DB_WORLD_NAME,
            'username'              => DB_WORLD_USER,
            'password'              => DB_WORLD_PASS,
            'emulatePrepare'        => true,
            'charset'               => 'utf8',
            'autoConnect'           => false,
            'schemaCachingDuration' => 3600,
        ),
        'cache'                 => array(
            'class' => 'system.caching.CFileCache',
        ),
        'log'   => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'     => 'CFileLogRoute',
                ),
            ),
        ),
        'bootstrap' => array(
            'class'     => 'ext.bootstrap.components.Bootstrap',
        ),
    ),
    'behaviors' => array(
        'runEnd' => array(
            'class'          => 'application.components.behaviors.WebApplicationEndBehavior',
        ),
        'onBeginRequest' => array(
            'class'  => 'application.components.behaviors.BeginRequest'
        ),
    ),
    'params' => require(dirname(__FILE__).'/params.php'),
);
