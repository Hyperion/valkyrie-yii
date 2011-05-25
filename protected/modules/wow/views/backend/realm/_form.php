<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'realmlist-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'host'); ?>
		<?php echo $form->textField($model,'host',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'host'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbname'); ?>
		<?php echo $form->textField($model,'dbname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'dbname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Connect'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
