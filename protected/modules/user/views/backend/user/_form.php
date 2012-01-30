<?php
$form = $this->beginWidget('BootActiveForm', array(
    'enableAjaxValidation' => true,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
        ));
?>

<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo CHtml::errorSummary(array($model, $profile)); ?>

<?php echo $form->textFieldRow($model, 'username'); ?>
<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->textFieldRow($model, 'email'); ?>
<?php echo $form->dropDownListRow($model, 'status', User::itemAlias('UserStatus')); ?>
<?php
$profileFields = $profile->getFields();
if ($profileFields):
    foreach ($profileFields as $field):
        if ($field->widgetEdit($profile))
        {
            echo $form->labelEx($profile, $field->varname);
            echo $field->widgetEdit($profile);
            echo $form->error($profile, $field->varname);
        }
        elseif ($field->range)
            echo $form->dropDownListRow($profile, $field->varname, Profile::range($field->range));
        elseif ($field->field_type == "TEXT")
            echo $form->textAreaRow($profile, $field->varname);
        else
            echo $form->textFieldRow($profile, $field->varname);
    endforeach;
endif;
?>
<div class="actions">
    <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn primary')); ?>
</div>

<?php $this->endWidget(); ?>