<?php
$profiles = $this->module->enableProfiles;

$this->breadcrumbs = array(Yii::t('UserModule.user', 'Users') => array('index'), $model->username);

echo Core::renderFlash();

$attributes = array('username');

if($profiles) {
	$profileFields = ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
				'label' => Yii::t('UserModule.user', $field->title),
				'name' => $field->varname,
				'value' => $model->profile->getAttribute($field->varname),
			));
		}
	}
}
array_push($attributes,
	array(
		'name' => 'createtime',
		'value' => date(UserModule::$dateFormat,$model->createtime),
	),
	array(
		'name' => 'lastvisit',
		'value' => date(UserModule::$dateFormat,$model->lastvisit),
	)
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$attributes,
));