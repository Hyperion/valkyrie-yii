<?php

require_once(dirname(__FILE__).'/local.conf');

return array(
    'basePath'   => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'       => 'My Console Application',
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
            'emulatePrepare'   => true,
            'username'         => DB_USER,
            'password'         => DB_PASS,
            'charset'          => 'utf8',
            'tablePrefix'      => '',
        ),
    ),
    'commandMap'       => array(
        'migrate' => array(
            'class'          => 'system.cli.commands.MigrateCommand',
            'migrationTable' => 'dev_migration',
        ),
    ),
);