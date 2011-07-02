<div class="form">
<p class="note"><?=Yii::t('UserModule.user', 'Fields with <span class="required">*</span> are required.')?></p>

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'profile-comment-form',
			'enableAjaxValidation'=>true,
			)); 
?>
<?=$form->errorSummary($comment)?>
<?=CHtml::hiddenField('ProfileComment[profile_id]', $profile->id)?>

<div class="row">
<?=$form->labelEx($comment,'comment')?>
<?=$form->textArea($comment,'comment',array('rows'=>6, 'cols'=>50))?>
<?=$form->error($comment,'comment')?>
</div>

<?=CHtml::Button(Yii::t('UserModule.user', 'Write comment'), array('id' => 'write_comment'))?>
<?
Yii::app()->clientScript->registerScript("write_comment", " 
		$('#write_comment').unbind('click');
		$('#write_comment').click(function(){
			jQuery.ajax({'type':'POST',
				'url':'".$this->createUrl('//user/profileComment/create')."',
				'cache':false,
				'data':jQuery(this).parents('form').serialize(),
				'success':function(html){
				$('#profile').html(html);
				}});
			return false;});
		");


$this->endWidget(); ?>

</div>
