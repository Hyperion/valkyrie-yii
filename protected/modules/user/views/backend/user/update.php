<?php

$this->breadcrumbs = array(
	Yii::t('UserModule.user', 'Users')=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	Yii::t('UserModule.user', 'Update'));
	
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'passwordform'=>$passwordform,
	'profile'=>$profile,)
);
