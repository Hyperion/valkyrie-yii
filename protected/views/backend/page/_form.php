<div class="form">
    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'type'                 => 'horizontal',
        'htmlOptions'          => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title'); ?>
    <?php echo $form->textFieldRow($model, 'url'); ?>
    <?php echo $form->textFieldRow($model, 'alt'); ?>
    <?php echo $form->textAreaRow($model, 'text', array('rows'  => 5, 'style' => 'width: 95%')); ?>
    <?php echo $form->textAreaRow($model, 'description', array('rows'  => 5, 'style' => 'width: 95%')); ?>
    <?php echo $form->textFieldRow($model, 'keywords'); ?>
    
    <?php if(!Yii::app()->request->isAjaxRequest) : ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php endif; ?>

    <?php $this->endWidget(); ?>

</div>

<?php
if(!$this->isAjax) :
    $this->cs->registerScript('handleImageUpload', '$.cleditor.buttons.image.uploadUrl = "' . Yii::app()->request->baseUrl . '/index.php/page/handleUpload";');
    $this->cs->clientScript->registerScript('text', '$("#Page_text").cleditor({\'width\':\'95%\',\'height\':250});', CClientScript::POS_LOAD);
endif;
?>
