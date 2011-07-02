<?php $this->title = Yii::t('UserModule.user', 'Permission Denied'); ?>
<div class="hint">
	<p> <?php echo Yii::t('UserModule.user', 'You are not allowed to view this profile.'); ?> </p>
  <p> <?php echo CHtml::link(Yii::t('UserModule.user', 'Back to your profile'), array('user/profile')); ?> </p>
</div>
