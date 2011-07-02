<?php
$this->breadcrumbs=array(Yii::t('UserModule.user', 'Messages')=>array('index'),$model->title);
?>

<h2> <?php echo Yii::t('UserModule.user', 'Message from') .  ' <em>' . $model->from_user->username . '</em>';

echo ': ' . $model->title; ?> 
</h2>

<hr />

<div class="message">
<?php echo $model->message; ?>
</div>

<hr />
<?php
echo CHtml::link(Yii::t('UserModule.user', 'Back to inbox'), array(
			'//user/messages/index')) . '<br />';

if(Yii::app()->user->id != $model->from_user_id) {
	echo CHtml::link(Yii::t('UserModule.user', 'Reply to message'), '', array(
				'onclick' => "$('.reply').toggle(500)"));

	echo '<div class="reply" style="display: none;">';
	$reply = new Message;

	if(substr($model->title, 0, 3) != 'Re:')
		$reply->title = 'Re: ' . $model->title;

	$this->renderPartial('reply', array(
				'to_user_id' => $model->from_user_id,
				'model' => $reply));
	echo '</div>';
}
?>
