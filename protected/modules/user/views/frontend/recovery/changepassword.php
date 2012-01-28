<?php 
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change Password"),
);
$this->pageCaption = UserModule::t("Change Password");
$form = $this->beginWidget('BootActiveForm');
echo UserModule::t('Fields with <span class="required">*</span> are required.');
echo CHtml::errorSummary($model);
echo $form->passwordFieldRow($model, 'password', array('hint' => UserModule::t("Minimal password length 4 symbols.")));
echo $form->passwordFieldRow($model, 'verifyPassword'); ?>
<div class="actions">
<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn primary')); ?>
</div>
<?php $this->endWidget(); ?>