<?php
$this->breadcrumbs = array();
?>
<h1>Добро пожаловать в админ панель!</h1>

<h3>Общие настройки сайта.</h3>


<?php
$form = $this->beginWidget('BootActiveForm', array(
    'enableAjaxValidation' => true,
    'type'                 => 'horizontal',
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>

<p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'title'); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'main_page', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.cleditor.ECLEditor', array(
            'model'     => $model,
            'attribute' => 'main_page',
            'options'   => array(
                'width'  => '95%',
                'height' => 250,
            ),
            'value'  => $model->main_page,
        ));
        ?>
    </div>
    <?php echo $form->error($model, 'main_page'); ?>
</div>
<?php echo $form->textFieldRow($model, 'email'); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows'  => 5, 'style' => 'width: 95%')); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('size'      => 60, 'maxlength' => 150)); ?>

<div class="form-actions">
    <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.cleditor.extimage.js'); ?>
<script type="text/javascript">
    $.cleditor.buttons.image.uploadUrl = '<?php echo Yii::app()->request->baseUrl ?>/index.php/page/handleUpload';
</script>
