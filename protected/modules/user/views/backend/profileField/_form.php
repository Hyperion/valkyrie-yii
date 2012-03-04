<div class="form">
    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'enableAjaxValidation' => true,
        'type'                 => 'horizontal',
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
    echo $form->textFieldRow($model, 'title', array(
        'class' => 'title',
        'hint'  => UserModule::t('Field name on the language of "sourceLanguage".')
    ));
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
    echo $form->textFieldRow($model, 'field_size_min', array(
        'class' => 'field_size_min',
        'hint'  => UserModule::t('The minimum value of the field (form validator).')));
    echo $form->dropDownListRow($model, 'required', ProfileField::itemAlias('required'), array(
        'class' => 'required',
        'hint'  => UserModule::t('Required field (form validator).')
    ));
    echo $form->textFieldRow($model, 'match', array(
        'class' => 'match',
        'hint'  => UserModule::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u').")
    ));
    echo $form->textFieldRow($model, 'range', array(
        'class' => 'range',
        'hint'  => UserModule::t('Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).')
    ));
    echo $form->textFieldRow($model, 'error_message', array(
        'class' => 'error_message',
        'hint'  => UserModule::t('Error message when you validate the form.')
    ));
    echo $form->textFieldRow($model, 'other_validator', array(
        'class' => 'other_validator',
        'hint'  => UserModule::t('JSON string (example: {example}).', array(
            '{example}' => CJavaScript::jsonEncode(array(
                'file' => array('types' => 'jpg, gif, png')
            ))
        ))
    ));
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
    list($widgetsList) = ProfileFieldController::getWidgets($model->field_type);
    echo $form->dropDownListRow($model, 'widget', $widgetsList, array(
        'id'    => 'widgetlist',
        'class' => 'widget',
        'hint'  => UserModule::t('Widget name.'),
    ));
    echo $form->textFieldRow($model, 'widgetparams', array(
        'class' => 'widgetparams',
        'id'    => 'widgetparams',
        'hint'  => UserModule::t('JSON string (example: {example}).', array(
            '{example}' => CJavaScript::jsonEncode(array(
                'param1' => array('val1', 'val2'),
                'param2' => array('k1' => 'v1', 'k2' => 'v2')
            ))))
    ));
    echo $form->textFieldRow($model, 'position', array(
        'class' => 'position',
        'hint'  => UserModule::t('Display order of fields.')));
    echo $form->dropDownListRow($model, 'visible', ProfileField::itemAlias('visible'), array(
        'class' => 'visible',
    ));
    ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div id="dialog-form" class="form" title="<?php echo UserModule::t('Widget parametrs'); ?>">
    <form>
        <div class="form-actions">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
            <label for="value">Значение</label>
            <input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
        </div>
    </form>
</div>
