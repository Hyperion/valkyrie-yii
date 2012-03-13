<?php
$this->breadcrumbs = array();
?>
<h1>Настройки галереи</h1>

<?php
$form = $this->beginWidget('BootActiveForm', array(
    'enableAjaxValidation' => true,
    'type'                 => 'horizontal',
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>

<p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'thumb_size'); ?>

<div class="form-actions">
    <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>
