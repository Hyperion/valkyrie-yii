<?php 
if(!$profile = @$model->profile)
	return false;

$this->breadcrumbs = array(Yii::t('UserModule.user', 'Profile'), $model->username);
Core::renderFlash(); 
?>

<div id="profile">

<?php 
if($model->id == Yii::app()->user->id && $this->module->messageSystem != false)
	$this->renderPartial('/messages/new_messages');
?>

<?=$model->getAvatar()?>
<?php $this->renderPartial('/profile/public_fields', array(
			'profile' => $model->profile)); ?>
<br />
<?php $this->renderPartial('/friendship/friends', array('model' => $model)); ?> 
<br /> 
<?php
if($this->module->messageSystem != Message::MSG_NONE)
 $this->renderPartial('/messages/write_a_message', array('model' => $model)); ?> 
<br /> 
<?php
 if(isset($model->profile))
	$this->renderPartial('/profileComment/index', array('model' => $model->profile)); ?> 
</div>
