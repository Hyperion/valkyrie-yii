<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../src/yii-read-only/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
