<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Hyperion\'s Sandbox',
    'language' => 'ru',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.*',
    ),

    // application components
    'components'=>array(
        'ipbBridge'=>array(
            'class'=>'IpbBridge',
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=project',
                'username' => 'root',
                'password' => '59tyr4pn',
                'charset' => 'utf8',
                'tablePrefix'=>'',
            ),
        ),
        'request'=>array(
            //'enableCsrfValidation'=>true,
            'enableCookieValidation'=>true,
        ),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=cms',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '59tyr4pn',
            'charset' => 'utf8',
            'tablePrefix'=>'',
            'schemaCachingDuration'=>3600,
        ),
        'db_world'=>array(
            'class'=>'CDbConnection',
            'connectionString'=>'mysql:host=localhost;dbname=world',
            'username'=>'root',
            'password'=>'59tyr4pn',
            'emulatePrepare'=> true,
            'charset' => 'utf8',
            'autoConnect' => false,
            'schemaCachingDuration'=>3600,
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts',
            'SMTPDebug' => 0,
            'SMTPAuth' => true,
            'SMTPSecure' => 'ssl',
            'Host' => 'smtp.gmail.com',
            'Port' => 465,
            'Username' => 'test.valkyrie.wow@gmail.com',
            'CharSet' => 'UTF_8',
            'Password' => 'pdpfer56df56',
            'From' => 'valkyrie.wow@gmail.com',
            'FromName' => 'Administration of Valkyrie-wow',
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                ),
            ),
        ),
    ),

    'behaviors'=>array(
        'runEnd'=>array(
            'class'=>'application.components.WebApplicationEndBehavior',
        ),
    ),

    'params'=>require(dirname(__FILE__).'/params.php'),
);
