<?php
$this->pageTitle = Yii::app()->name.' - '.UserModule::t("Login");

if (Yii::app()->user->hasFlash('success')):
    $this->widget('BootAlert', array(
        'template' => '<div class="alert-message block-message {key}"><p>{message}</p></div>',
    ));
endif;
?>
<div class="container">
    <div class="content">
        <div>
        <h1>Админ панель</h1>
        <p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>
        <?php
        $form      = $this->beginWidget('BootActiveForm');
        echo UserModule::t('Fields with <span class="required">*</span> are required.');
        echo CHtml::errorSummary($model);
        echo $form->textFieldRow($model, 'username');
        echo $form->passwordFieldRow($model, 'password');
        ?>
        <div class="actions">
            <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn primary')); ?>
        </div>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div>