<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'realmlist-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'port'); ?>
		<?php echo $form->textField($model,'port'); ?>
		<?php echo $form->error($model,'port'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo $form->textField($model,'icon'); ?>
		<?php echo $form->error($model,'icon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model,'color'); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timezone'); ?>
		<?php echo $form->textField($model,'timezone'); ?>
		<?php echo $form->error($model,'timezone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allowedSecurityLevel'); ?>
		<?php echo $form->textField($model,'allowedSecurityLevel'); ?>
		<?php echo $form->error($model,'allowedSecurityLevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'population'); ?>
		<?php echo $form->textField($model,'population'); ?>
		<?php echo $form->error($model,'population'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realmbuilds'); ?>
		<?php echo $form->textField($model,'realmbuilds',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'realmbuilds'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->