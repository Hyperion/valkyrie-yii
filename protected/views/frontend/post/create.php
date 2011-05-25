<?php
$this->breadcrumbs=array(
	'Create Material',
);
?>
<h1>Create Material</h1>

    <form id="file_upload" action="upload" method="POST" enctype="multipart/form-data"> 
        <input type="file" name="file[]"> 
        <button type="submit">Upload</button> 
        <div class="file_upload_label">Upload files</div> 
    </form> 
    <table id="files"> 
    </table> 

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'img'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo CHtml::activeTextArea($model,'content',array('rows'=>10, 'cols'=>70)); ?>
		<p class="hint">You may use <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a>.</p>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
    	<?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList($model,'category_id', Category::items()); ?>
        <?php echo $form->error($model,'category_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array(
		      Material::STATUS_DRAFT => 'Draft',
		      Material::STATUS_PUBLISHED => 'Published',
		      Material::STATUS_ARCHIVED => 'Archived')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Create'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
