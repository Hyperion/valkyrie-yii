<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=cms',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '59tyr4pn',
            'charset' => 'utf8',
            'tablePrefix'=>'',
        ),
    ),
    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationTable'=>'dev_migration',
        ),
    ),
);