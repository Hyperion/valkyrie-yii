<?php
$this->pageTitle = Yii::app()->name . ' - Связь с нами';
$this->pageCaption = 'Связь с нами';
$this->breadcrumbs = array(
    'Contact',
);
?>

<h3>Контактные данные</h3>
<div><?php echo Yii::app()->config->get('contact_info'); ?></div>
<?php if(Yii::app()->user->hasFlash('success')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

<?php else: ?>
    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'enableClientValidation' => false,
        'type'                   => 'horizontal',
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <p class="note">Поля помеченые звездочкой <span class="required">*</span> - объязательные для заполнения.</p>

    <?php echo $form->errorSummary($model, 'Допущены ошибки'); ?>

    <?php echo $form->textFieldRow($model, 'name'); ?>
    <?php echo $form->textFieldRow($model, 'email'); ?>
    <?php echo $form->textFieldRow($model, 'subject'); ?>
    <?php echo $form->textAreaRow($model, 'body', array('rows' => 6,'style' => 'width: 95%')); ?>

    <?php if(CCaptcha::checkRequirements()): ?>
        <?php $this->widget('CCaptcha', array('imageOptions' => array('class'         => 'offset2'), 'buttonOptions' => array('class' => 'offset2 captchaLink'))); ?>
        <?php echo $form->textFieldRow($model, 'verifyCode'); ?>
        <div class="hint">Необходимо ввести буквы с изображения.</div>
    <?php endif; ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton("Отправить", array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php endif; ?>
