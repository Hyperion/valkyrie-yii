<?php
$form = $this->beginWidget('BootActiveForm', array(
    'type'                 => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>

<?php if(!$model->isNewRecord) : ?>
    <div class="controls"><?php echo CHtml::image($model->cover->thumb_url); ?></div>
<?php endif; ?>
    
<p class="help-block">Поля, отмеченные <span class="required">*</span> обязательны.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name'); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows'  => 5, 'style' => 'width: 95%')); ?>
<?php echo $form->checkBoxRow($model, 'visible'); ?>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>
<?php endif; ?>

<?php $this->endWidget(); ?>
