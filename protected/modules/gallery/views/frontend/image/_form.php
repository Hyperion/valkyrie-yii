<?php
$form = $this->beginWidget('BootActiveForm', array(
    'enableAjaxValidation' => true,
    'type'                 => 'horizontal',
    ));
?>

<div class="controls"><?php echo CHtml::image($model->thumb_url); ?></div>

<p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

<?php echo CHtml::errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'image'); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows'  => 5, 'style' => 'width: 95%')); ?>

<?php if(!Yii::app()->request->isAjaxRequest) : ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Загрузить' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>
<?php endif; ?>

<?php $this->endWidget(); ?>
