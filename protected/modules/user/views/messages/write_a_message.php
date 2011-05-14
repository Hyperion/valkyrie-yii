<?php
if($this->module->messageSystem != Message::MSG_NONE && $model->id != Yii::app()->user->id) {

echo '<div style="display: none;" id="write_a_message">';

	$this->renderPartial($this->module->messageComposeView, array(
				'model' => new Message,
				'to_user_id' => $model->id), false, true);

echo '</div>';

	echo CHtml::link(Yii::t('UserModule.user', 'Write a message to this User'), '',
			array('onclick'=>"$('#write_a_message').toggle(500);"));
}
?>
