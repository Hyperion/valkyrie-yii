<?php
if(!$profile = @$model->profile)
	return false;

if($profile->show_friends == 2) {
	echo '<div id="friends">';
		if(isset($model->friends)) {
			echo '<h2>' . Yii::t('UserModule.user', 'Friends of {username}', array(
						'{username}' => $model->username)) . '</h2>';
			foreach($model->friends as $friend) {
				?>
					<div class="friend">
					<div class="avatar">
					<?php
					echo $friend->getAvatar(true);
				?>
					<div class="username">
					<?php 
					echo CHtml::link(ucwords($friend->username),
							Yii::app()->createUrl('user/profile/view',array(
									'id'=>$friend->id)));
				?>
					</div>
					</div>
					</div>
					<?php
			}
		} else {
			echo Yii::t('UserModule.user', '{username} has no friends yet', array(
						'{username}' => $model->username)); 
		}
echo '</div><!-- friends -->';
}
echo FriendshipController::invitationLink(Yii::app()->user->id, $model->id);
?>
