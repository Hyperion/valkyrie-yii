<?php
$this->pageTitle = Yii::app()->name.' - '.UserModule::t("Profile");
$this->breadcrumbs = array(
    UserModule::t("Profile") => array('profile'),
    UserModule::t("Edit"),
);
$this->pageCaption = UserModule::t('Edit profile');
?>

<?php
$this->widget('BootAlert', array(
    'template' => '<div class="alert-message block-message {key}"><p>{message}</p></div>',
));

$form      = $this->beginWidget('BootActiveForm', array(
    'id'                   => 'profile-form',
    'enableAjaxValidation' => true,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));

echo UserModule::t('Fields with <span class="required">*</span> are required.');
echo $form->errorSummary(array($model, $profile));

$profileFields = $profile->getFields();
if ($profileFields) :
    foreach ($profileFields as $field) :
        if ($field->widgetEdit($profile))
            echo $field->widgetEdit($profile);
        elseif ($field->range)
            echo $form->dropDownListRow($profile, $field->varname, Profile::range($field->range));
        elseif ($field->field_type == "TEXT")
            echo $form->textAreaRow($profile, $field->varname, array('rows' => 6, 'cols' => 50));
        else
            echo $form->textFieldRow($profile, $field->varname, array('size'      => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
    endforeach;
endif;
echo $form->textFieldRow($model, 'username');
echo $form->textFieldRow($model, 'email'); ?>
<div class="actions">
    <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn primary')); ?>
</div>
<?php $this->endWidget(); ?>