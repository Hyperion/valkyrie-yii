<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../src/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/frontend.php';

defined('YII_DEBUG') or define('YII_DEBUG', false);

require_once($yii);
Yii::createWebApplication($config)->runEnd('frontend');
