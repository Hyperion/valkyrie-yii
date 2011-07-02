<?php
$this->title = Yii::t('UserModule.user', 'Request friendship for user {username}', array('{username}' => $invited->username));
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Friendship'), Yii::t('UserModule.user', 'Invitation'), $invited->username);

$friendship_status = $invited->isFriendOf(Yii::app()->user->id);
	if($friendship_status !== false)  {
		if($friendship_status == 1)
			echo Yii::t('UserModule.user', 'Friendship request already sent');
		if($friendship_status == 2)
			echo Yii::t('UserModule.user', 'You already are friends');
		if($friendship_status == 3)
			echo Yii::t('UserModule.user', 'Friendship request has been rejected');

		return false;
	} else {
		if(isset($friendship))
			echo CHtml::errorSummary($friendship);

		echo CHtml::beginForm(array('friendship/invite'));
		echo CHtml::hiddenField('user_id', $invited->id);
		echo CHtml::label(Yii::t('UserModule.user', 'Please enter a request Message up to 255 characters'), 'message');
		echo '<br />';
		echo CHtml::textArea('message', '', array('cols' =>60, 'rows' => 10));
		echo '<br />';
		echo CHtml::submitButton(Yii::t('UserModule.user', 'Send invitation'));
		echo CHtml::endForm();
	}
?>

