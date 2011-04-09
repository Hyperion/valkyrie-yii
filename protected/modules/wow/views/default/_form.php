<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textArea($model,'image',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'header_image'); ?>
		<?php echo $form->textArea($model,'header_image',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'header_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_de'); ?>
		<?php echo $form->textArea($model,'title_de',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_de'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_en'); ?>
		<?php echo $form->textArea($model,'title_en',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_es'); ?>
		<?php echo $form->textArea($model,'title_es',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_es'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_fr'); ?>
		<?php echo $form->textArea($model,'title_fr',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_fr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_ru'); ?>
		<?php echo $form->textArea($model,'title_ru',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_de'); ?>
		<?php echo $form->textArea($model,'desc_de',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'desc_de'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_en'); ?>
		<?php echo $form->textArea($model,'desc_en',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'desc_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_es'); ?>
		<?php echo $form->textArea($model,'desc_es',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'desc_es'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_fr'); ?>
		<?php echo $form->textArea($model,'desc_fr',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'desc_fr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_ru'); ?>
		<?php echo $form->textArea($model,'desc_ru',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'desc_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_de'); ?>
		<?php echo $form->textArea($model,'text_de',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_de'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_en'); ?>
		<?php echo $form->textArea($model,'text_en',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_es'); ?>
		<?php echo $form->textArea($model,'text_es',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_es'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_fr'); ?>
		<?php echo $form->textArea($model,'text_fr',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_fr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_ru'); ?>
		<?php echo $form->textArea($model,'text_ru',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textArea($model,'author',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postdate'); ?>
		<?php echo $form->textField($model,'postdate'); ?>
		<?php echo $form->error($model,'postdate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->