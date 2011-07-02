<?php 
$user = User::model()->findByPk(Yii::app()->user->id);

if($user->friendship_requests) {
	$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=> Yii::t('UserModule.user', 'New friendship requests')));
	foreach($user->friendship_requests as $friendship) {
		printf('<li> %s: %s </li>',
				date($this->module->dateTimeFormat, $friendship->requesttime),
				CHtml::link($friendship->inviter->username, array(
						'//user/profile/view', 'id' => $friendship->inviter->id)));
	}
	echo CHtml::link(Yii::t('UserModule.user', 'Manage friends'), array('/user/friendship'));
	$this->endWidget();
}
?>

