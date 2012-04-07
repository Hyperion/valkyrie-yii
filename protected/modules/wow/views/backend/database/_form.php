<?php
$form = $this->beginWidget('BootActiveForm', array(
    'type'                 => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>

<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name'); ?>
<?php echo $form->textFieldRow($model, 'host'); ?>
<?php echo $form->textFieldRow($model, 'username'); ?>
<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->textFieldRow($model, 'database'); ?>
<?php echo $form->dropDownListRow($model, 'type', Database::itemAlias('type')); ?>
<?php echo $form->dropDownListRow($model, 'adapter', Database::itemAlias('adapter')); ?>


<div class="form-actions">
<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Save'), array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>