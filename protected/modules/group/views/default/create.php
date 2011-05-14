<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-create-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="row">
                <?php echo $form->labelEx($model,'post_id'); ?>
	        <?php echo $form->textField($model,'post_id'); ?>
                <?php echo $form->error($model,'post_id'); ?>
        </div>


	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php echo $form->fileField($model,'avatar'); ?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array(
			Group::TYPE_POSITIVE => 'positive',
			Group::TYPE_NEGATIVE => 'negative',
		)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'government'); ?>
		<?php echo $form->dropDownList($model,'government',array(
			Group::GOV_MONARCHY => 'monarchy',
			Group::GOV_ANARCHY  => 'anarchy',
			Group::GOV_REPUBLIC => 'republic',
		)); ?>
		<?php echo $form->error($model,'government'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
