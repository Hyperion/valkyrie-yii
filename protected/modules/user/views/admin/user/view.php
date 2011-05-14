<?php
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Users') => array('index'), $model->username);

echo Core::renderFlash();

$attributes = array('id');

if(!$this->module->loginType & UserModule::LOGIN_BY_EMAIL)
	$attributes[] = 'username';

$profileFields = ProfileField::model()->forOwner()->sort()->findAll();
if ($profileFields && $model->profile)
{
	foreach($profileFields as $field) {
		array_push($attributes, array(
			'label' => Yii::t('UserModule.user', $field->title),
			'type' => 'raw',
			'value' => $model->profile->getAttribute($field->varname),
		));
	}
}

array_push($attributes,
	'activationKey',
	array(
		'name' => 'createtime',
		'value' => date(UserModule::$dateFormat,$model->createtime),
	),
	array(
		'name' => 'lastvisit',
		'value' => date(UserModule::$dateFormat,$model->lastvisit),
	),
	array(
		'name' => 'lastpasswordchange',
		'value' => date(UserModule::$dateFormat,$model->lastpasswordchange),
	),
	array(
		'name' => 'superuser',
		'value' => User::itemAlias("AdminStatus",$model->superuser),
	),
	array(
		'name' => 'status',
		'value' => User::itemAlias("UserStatus",$model->status),
	)
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$attributes,
));

echo CHtml::Button(
	Yii::t('UserModule.user', 'Update User'), array(
		'submit' => array('/admin/user/user/update', 'id' => $model->id)));

echo CHtml::Button(
	Yii::t('UserModule.user', 'Visit profile'), array(
		'submit' => array('/admin/user/profile/view', 'id' => $model->id)));
