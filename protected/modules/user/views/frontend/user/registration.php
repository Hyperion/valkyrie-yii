<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
$this->breadcrumbs = array(
    UserModule::t("Registration"),
);
$this->pageCaption = UserModule::t("Registration");
if(Yii::app()->user->hasFlash('success')):
    $this->widget('BootAlert');
else:
    $form = $this->beginWidget('BootActiveForm', array(
        'id'                   => 'registration-form',
        'enableAjaxValidation' => true,
        'type'                 => 'horizontal',
        'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
    ?>

    <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary(array($model, $profile)); ?>

    <?php echo $form->textFieldRow($model, 'username'); ?>
    <?php echo $form->passwordFieldRow($model, 'password', array('hint'         => UserModule::t("Minimal password length 4 symbols."))); ?>
    <?php echo $form->passwordFieldRow($model, 'verifyPassword'); ?>
    <?php echo $form->textFieldRow($model, 'email'); ?>

    <?php
    $profileFields = $profile->getFields();
    if($profileFields):
        foreach($profileFields as $field):
            if($field->widgetEdit($profile))
            {
                echo $form->labelEx($profile, $field->varname);
                echo $field->widgetEdit($profile);
                echo $form->error($profile, $field->varname);
            }
            elseif($field->range)
                echo $form->dropDownListRow($profile, $field->varname, Profile::range($field->range));
            elseif($field->field_type == "TEXT")
                echo $form->textAreaRow($profile, $field->varname);
            else
                echo $form->textFieldRow($profile, $field->varname);
        endforeach;
    endif;
    if(UserModule::doCaptcha('registration')):
        ?>
        <div class="row">
            <?php
            $this->widget('CCaptcha', array(
                'imageOptions' => array('class'         => 'offset2'),
                'buttonOptions' => array('class' => 'offset2 captchaLink'),
            ));
            ?>
        </div>
        <?php echo $form->textFieldRow($model, 'verifyCode', array('hint' => UserModule::t("Please enter the letters as they are shown in the image above.") . '<br/>' . UserModule::t("Letters are not case-sensitive."))); ?>
    <?php endif; ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php endif; ?>