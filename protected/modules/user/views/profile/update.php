<?php 
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('UserModule.user',  "Profile");
$this->breadcrumbs=array(
		Yii::t('UserModule.user', 'Profile') => array('profile'),
		Yii::t('UserModule.user', 'Edit profile'));
$this->title = Yii::t('UserModule.user', 'Edit profile');
?>

<div class="form">

<?php echo CHtml::beginForm(); ?>

<?php echo Core::requiredFieldNote(); ?>

<?php echo CHtml::errorSummary(array($user, $profile)); ?>

<div class="row">
<?php echo CHtml::activeLabelEx($user,'username'); ?>
<?php echo CHtml::activeTextField($user,'username',array(
			'size'=>20,'maxlength'=>20)); ?>
<?php echo CHtml::error($user,'username'); ?>
</div>

<?php if(isset($profile) && is_object($profile)) 
	$this->renderPartial('/profile/_form', array('profile' => $profile)); ?>

	<div class="row buttons">
	<?php

	if($this->module->enablePrivacysetting)
		echo CHtml::button(Yii::t('UserModule.user', 'Privacy settings'), array(
					'submit' => array('/user/privacy/update'))); ?>

	<?php 
		if($this->module->enableAvatar)
			echo CHtml::button(Yii::t('UserModule.user', 'Upload avatar Image'), array(
				'submit' => array('/user/avatar/editAvatar'))); ?>

	<?php echo CHtml::submitButton($user->isNewRecord 
			? Yii::t('UserModule.user', 'Create my profile') 
			: Yii::t('UserModule.user', 'Save profile changes')); ?>
	</div>

	<?php echo CHtml::endForm(); ?>

	</div><!-- form -->
