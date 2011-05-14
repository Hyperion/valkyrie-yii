<div class="guestbook">
	<div class="guestbook-header">
			<strong><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</strong>
			<?php echo CHtml::link(CHtml::encode($data->user->username), array(
						'//user/profile/view', 'id' => $data->user_id)); ?>
			|
			<strong><?php echo CHtml::encode($data->getAttributeLabel('createtime')); ?>:</strong>
			<?php $locale = CLocale::getInstance(Yii::app()->language);
			echo $locale->getDateFormatter()->formatDateTime($data->createtime, 'medium', 'medium'); ?>
	</div>
		
	<div class="guestbook-avatar">
		<?php echo $data->user->getAvatar(true); ?>
	</div>

	<div class="guestbook-comment">
		<?php echo CHtml::encode($data->comment); ?>
	</div>
	
	<div class="guestbook-footer">
			<?php
				// the owner of the profile as well as the owner of the comment can remove
				if($data->user_id == Yii::app()->user->id
						|| $data->profile_id == Yii::app()->user->id) {
					echo CHtml::Button(Yii::t('UserModule.user', 'Remove comment'), array(
								'confirm' => Yii::t('UserModule.user', 'Are you sure to remove this comment from your profile?'),
								'submit' => array( '//user/profileComment/delete', 'id' => $data->id)));
				}		
			?>
	</div>

</div>
