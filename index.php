<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../src/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message

require_once($yii);
Yii::createWebApplication($config)->run();
