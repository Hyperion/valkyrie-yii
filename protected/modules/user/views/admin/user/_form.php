<div class="form">
<?php 

$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false));
?>

<div class="note">
<?=Yii::t('UserModule.user', 'Fields with <span class="required">*</span> are required.')?>
<?=CHtml::errorSummary(array($model,
 $passwordform,
 isset($profile) ? $profile : null ))?>
</div>

<div style="float: right; margin: 10px;">
<div class="row">
<?=$form->labelEx($model, 'superuser')?>
<?=$form->dropDownList($model, 'superuser',User::itemAlias('AdminStatus'))?>
<?=$form->error($model, 'superuser')?>
</div>

<div class="row">
<?=$form->labelEx($model,'status')?>
<?=$form->dropDownList($model,'status',User::itemAlias('UserStatus'))?>
<?=$form->error($model,'status')?>
</div>
</div>

<div class="row">
<?=$form->labelEx($model, 'username')?>
<?=$form->textField($model, 'username')?>
<?=$form->error($model, 'username')?>
</div>

<div class="row">
<p>
	Leave password <em> empty </em> to 
	<?=$model->isNewRecord ? 'generate a random Password' : 'keep it <em> unchanged </em>'?>
</p>
<?php $this->renderPartial('/user/passwordfields', array('form'=>$passwordform)); ?>
</div>
<?php $this->renderPartial('/profile/_form', array('profile' => $profile)); ?>
<div class="row buttons">
<?=CHtml::submitButton($model->isNewRecord
			? Yii::t('UserModule.user', 'Create')
			: Yii::t('UserModule.user', 'Save'))?>
</div>

<?php $this->endWidget(); ?>
</div>
<div style="clear:both;"></div>
