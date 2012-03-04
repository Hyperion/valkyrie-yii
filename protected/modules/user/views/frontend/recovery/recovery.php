<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Restore");
$this->breadcrumbs = array(
    UserModule::t("Login") => array('/user/login'),
    UserModule::t("Restore"),
);
$this->pageCaption = UserModule::t("Restore");
?>

<?php
if(Yii::app()->user->hasFlash('error') or Yii::app()->user->hasFlash('succes')):
    $this->widget('BootAlert', array(
        'template' => '<div class="alert-message block-message {key}"><p>{message}</p></div>',
    ));
else:
    $form = $this->beginWidget('BootActiveForm', array(
        'type' => 'horizontal',
            ));
    echo CHtml::errorSummary($model);
    echo $form->textFieldRow($model, 'login_or_email', array('hint' => UserModule::t("Please enter your login or email addres.")));
    ?>
    <div class="form-actions">
    <?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>