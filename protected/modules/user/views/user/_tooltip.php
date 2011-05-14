<?php

$template = '<p> %s: %s </p>';

if($data->isOnline()) {
echo Yii::t('UserModule.user', 'User is Online!');
echo CHtml::image(Core::register('images/green_button.png'));
}

	printf($template, Yii::t('UserModule.user', 'Username'), $data->username);

	printf($template, Yii::t('UserModule.user', 'First visit'), date(UserModule::$dateFormat, $data->createtime)); 
	printf($template, Yii::t('UserModule.user', 'Last visit'), date(UserModule::$dateFormat, $data->lastvisit)); 

	echo CHtml::link(Yii::t('UserModule.user', 'Write a message'), array(
			'//user/messages/compose', 'to_user_id' => $data->id)) . '<br />';
echo CHtml::link(Yii::t('UserModule.user', 'Visit profile'), array(
			'//user/profile/view', 'id' => $data->id));




