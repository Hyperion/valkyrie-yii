<div class="form">

    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'enableAjaxValidation' => true,
        'type' => 'horizontal',
        'htmlOptions'          => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title'); ?>
    <?php echo $form->textFieldRow($model, 'url'); ?>
    <?php echo $form->textFieldRow($model, 'alt'); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'text', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('application.extensions.cleditor.ECLEditor', array(
                'model'     => $model,
                'attribute' => 'text',
                'options'   => array(
                    'width'  => '95%',
                    'height' => 250,
                ),
                'value'  => $model->text,
            ));
            ?>
        </div>
        <?php echo $form->error($model,'text'); ?>
    </div>
    <?php echo $form->textAreaRow($model, 'meta', array('rows' => 5, 'style' => 'width: 95%')); ?>
    <?php echo $form->textFieldRow($model, 'keywords'); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.cleditor.extimage.js'); ?>
<script type="text/javascript">
$.cleditor.buttons.image.uploadUrl = '<?php echo Yii::app()->request->baseUrl ?>/index.php/page/handleUpload';
</script>
