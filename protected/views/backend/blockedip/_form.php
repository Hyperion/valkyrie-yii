<div class="form">
    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'enableAjaxValidation' => true,
        'type'                 => 'horizontal',
        'htmlOptions'          => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'mask'); ?>
    
    <?php if(!Yii::app()->request->isAjaxRequest) : ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php endif; ?>

    <?php $this->endWidget(); ?>

</div>
