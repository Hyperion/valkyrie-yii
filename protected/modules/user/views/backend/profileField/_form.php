<?php
$form = $this->beginWidget('BootActiveForm', array(
    'enableAjaxValidation' => true,
        ));
?>

<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo CHtml::errorSummary($model); ?>

<?php
echo ($model->id) ?
        $form->textFieldRow($model, 'varname', array(
            'class'    => 'varname',
            'readonly' => true,
            'hint'     => UserModule::t("Allowed lowercase letters and digits.")
        )) :
        $form->textFieldRow($model, 'varname', array(
            'class' => 'varname',
            'hint'  => UserModule::t("Allowed lowercase letters and digits.")
        ));
?>
<?php
echo $form->textFieldRow($model, 'title', array(
    'class' => 'title',
    'hint'  => UserModule::t('Field name on the language of "sourceLanguage".')
));
?>
<?php
echo ($model->id) ?
        $form->textFieldRow($model, 'field_type', array(
            'class'    => 'field_type',
            'readonly' => true,
            'id'       => 'field_type',
            'hint'     => UserModule::t('Field type column in the database.')
        )) :
        $form->dropDownListRow($model, 'field_type', ProfileField::itemAlias('field_type'), array(
            'class' => 'field_type',
            'id'    => 'field_type',
            'hint'  => UserModule::t('Field type column in the database.')
        ));
?>
<?php
echo ($model->id) ?
        $form->textFieldRow($model, 'field_size', array(
            'class'    => 'field_size',
            'readonly' => true,
            'hint'     => UserModule::t("Field size column in the database.")
        )) :
        $form->textFieldRow($model, 'field_size', array(
            'class' => 'field_size',
            'hint'  => UserModule::t("Field size column in the database.")
        ));
?>

<?php
echo $form->textFieldRow($model, 'field_size_min', array(
    'class' => 'field_size_min',
    'hint'  => UserModule::t('The minimum value of the field (form validator).')));
?>

<?php
echo $form->dropDownListRow($model, 'required', ProfileField::itemAlias('required'), array(
    'class' => 'required',
    'hint'  => UserModule::t('Required field (form validator).')
));
?>

<?php
echo $form->textFieldRow($model, 'match', array(
    'class' => 'match',
    'hint'  => UserModule::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u').")
));
?>

<?php
echo $form->textFieldRow($model, 'range', array(
    'class' => 'range',
    'hint'  => UserModule::t('Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).')
));
?>

<?php
echo $form->textFieldRow($model, 'error_message', array(
    'class' => 'error_message',
    'hint'  => UserModule::t('Error message when you validate the form.')
));
?>

<?php
echo $form->textFieldRow($model, 'other_validator', array(
    'class' => 'other_validator',
    'hint'  => UserModule::t('JSON string (example: {example}).', array(
        '{example}' => CJavaScript::jsonEncode(array(
            'file' => array('types' => 'jpg, gif, png')
        ))
    ))
));
?>

<?php
echo ($model->id) ?
        $form->textFieldRow($model, 'default', array(
            'class'    => 'default',
            'readonly' => true,
            'hint'     => UserModule::t("The value of the default field (database).")
        )) :
        $form->textFieldRow($model, 'default', array(
            'class' => 'default',
            'hint'  => UserModule::t("The value of the default field (database).")
        ));
?>

<?php
list($widgetsList) = ProfileFieldController::getWidgets($model->field_type);
echo $form->dropDownListRow($model, 'widget', $widgetsList, array(
    'id'    => 'widgetlist',
    'class' => 'widget',
    'hint'  => UserModule::t('Widget name.'),
));
?>

<?php
echo $form->textFieldRow($model, 'widgetparams', array(
    'class' => 'widgetparams',
    'id'    => 'widgetparams',
    'hint'  => UserModule::t('JSON string (example: {example}).', array(
        '{example}' => CJavaScript::jsonEncode(array(
            'param1' => array('val1', 'val2'),
            'param2' => array('k1' => 'v1', 'k2' => 'v2')
        ))))
));
?>

<?php
echo $form->textFieldRow($model, 'position', array(
    'class' => 'position',
    'hint'  => UserModule::t('Display order of fields.')));
?>

<?php
echo $form->dropDownListRow($model, 'visible', ProfileField::itemAlias('visible'), array(
    'class' => 'visible',
));
?>

<div class="actions">
<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn primary')); ?>
</div>

<?php $this->endWidget(); ?>

<div id="dialog-form" title="<?php echo UserModule::t('Widget parametrs'); ?>">
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
            <label for="value">Value</label>
            <input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>
