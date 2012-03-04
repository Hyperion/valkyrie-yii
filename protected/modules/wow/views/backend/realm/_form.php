<?php
$form = $this->beginWidget('BootActiveForm', array(
    'id'                   => 'realmlist-form',
    'type'                 => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'host'); ?>
<?php echo $form->textFieldRow($model, 'user'); ?>
<?php echo $form->textFieldRow($model, 'password'); ?>
<?php echo $form->textFieldRow($model, 'dbname'); ?>


<div class="form-actions">
<?php echo CHtml::submitButton('Connect', array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>