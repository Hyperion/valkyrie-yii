<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'     => 'Hyperion\'s Sandbox',
    'language' => 'ru',
    // preloading 'log' component
    'preload'  => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.*',
    ),
    // application components
    'components' => array(
        'ipbBridge' => array(
            'class' => 'IpbBridge',
            'db'    => array(
                'connectionString' => 'mysql:host='.DB_FORUM_HOST.';dbname='.DB_FORUM_NAME,
                'username'         => DB_FORUM_USER,
                'password'         => DB_FORUM_PASS,
                'charset'          => 'utf8',
                'tablePrefix'      => '',
            ),
        ),
        'request'          => array(
            //'enableCsrfValidation'=>true,
            'enableCookieValidation' => true,
        ),
        'db'                     => array(
            'connectionString'      => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
            'emulatePrepare'        => true,
            'username'              => DB_USER,
            'password'              => DB_PASS,
            'charset'               => 'utf8',
            'tablePrefix'           => '',
            'schemaCachingDuration' => 3600,
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
    ),
    'behaviors' => array(
        'runEnd' => array(
            'class'  => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    'params' => require(dirname(__FILE__).'/params.php'),
);
