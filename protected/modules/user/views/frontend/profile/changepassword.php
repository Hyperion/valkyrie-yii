<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Change Password");
$this->breadcrumbs = array(
    UserModule::t("Profile") => array('/user/profile'),
    UserModule::t("Change Password"),
);
$this->pageCaption = UserModule::t("Change password");
$form = $this->beginWidget('BootActiveForm', array(
    'id'                   => 'changepassword-form',
    'type'                 => 'horizontal',
    'enableAjaxValidation' => true,
        ));
echo UserModule::t('Fields with <span class="required">*</span> are required.');
echo CHtml::errorSummary($model);
echo $form->passwordFieldRow($model, 'password', array('hint' => UserModule::t("Minimal password length 4 symbols.")));
echo $form->passwordFieldRow($model, 'verifyPassword');
?>
<div class="form-actions">
<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn btn-primary')); ?>
</div>
<?php $this->endWidget(); ?>