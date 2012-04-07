<?php
$this->breadcrumbs = array('Галерея');
?>

<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'    => 'tabs',
    'stacked' => false,
    'items'   => array(
        array('label' => 'Настройки', 'url'   => array('/gallery/default'), 'active' => true),
        array('label' => 'Статистика', 'url'   => array('/gallery/default/statistic')),
    ),
));
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
