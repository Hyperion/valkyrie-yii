<?php 
/*if(!isset($this->title) || $this->title == '')
	$this->title = Yii::t('UserModule.user', 'Composing new message'); */
if($this->breadcrumbs == array())
	$this->breadcrumbs = array(Yii::t('UserModule.user', 'Messages'), Yii::t('UserModule.user', 'Compose'));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'yum-messages-form',
			'action' => array('//user/messages/compose'),
			'enableAjaxValidation'=>true,
			)); ?>

<?php echo Core::requiredFieldNote(); 

echo $form->errorSummary($model); 

if($to_user_id) {
	echo CHtml::hiddenField('Message[to_user_id]', $to_user_id);
	echo Yii::t('UserModule.user', 'This message will be sent to {username}', array(
				'{username}' => User::model()->findByPk($to_user_id)->username));
} else {
	echo $form->label($model, 'to_user_id');
	echo $form->dropDownList($model, 'to_user_id', 
			CHtml::listData(Yii::app()->user->data()->getFriends(), 'id', 'username'));
	echo '<div class="hint">'.Yii::t('UserModule.user', 'Only your friends are shown here').'</div>';

}
?>
<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'message'); ?>
<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'message'); ?>
</div>

<div class="row buttons">

<?php echo CHtml::submitButton($model->isNewRecord 
			? Yii::t('UserModule.user', 'Send') 
			: Yii::t('UserModule.user', 'Save'));
?>

</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
