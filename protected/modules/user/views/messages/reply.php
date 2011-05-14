<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'yum-messages-form',
			'action' => array('//user/messages/compose'),
			'enableAjaxValidation'=>true,
			)); ?>

<?=Yii::t('UserModule.user', 'Fields with <span class="required">*</span> are required.')?> 

<?=CHtml::hiddenField('Message[to_user_id]', $to_user_id)?>
<?=Yii::t('UserModule.user', 'This message will be sent to {username}', array(
				'{username}' => User::model()->findByPk($to_user_id)->username))?>

<div class="row">
<?=$form->labelEx($model,'title')?>
<?=$form->textField($model,'title',array('size'=>45,'maxlength'=>45))?>
<?=$form->error($model,'title')?>
</div>

<div class="row">
<?=$form->labelEx($model,'message')?>
<?=$form->textArea($model,'message',array('rows'=>6, 'cols'=>50))?>
<?=$form->error($model,'message')?>
</div>

<div class="row buttons">
<?=CHtml::submitButton(Yii::t('UserModule.user', 'Reply'))?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
