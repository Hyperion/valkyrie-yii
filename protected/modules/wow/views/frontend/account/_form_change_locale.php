<div class="dashboard-form" id="change-locale">
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>false,
)); ?>
<h4>Смена локализации</h4>
<p>Используйте эту форму для смены локализации.</p>
<div class="form-row required">
    <?=$form->labelEx($model,'locale')?>
    <?=$form->dropDownList($model,'locale', array(
        '0' => 'English',
        '8' => 'Русская'))?>
    <?=$form->error($model,'locale')?>
</div>
<p></p>
<p>Прежде чем применять Русскую локализацию, положите папку <a href="http://valkyrie-wow.com/Fonts.zip">Fonts</a> в корневую папку с игрой! После каждой смены локализации удаляйте папку WDB(кеш)!</p>
<fieldset class="ui-controls " >
<button
class="ui-button button1"
type="submit"
tabindex="1">
<span>
<span>Сменить локализацию</span>
</span>
</button>
<a class="ui-cancel " href="#" onclick="DashboardForm.hide($('#change-locale')); return false;" tabindex="1">
<span>Отмена</span>
</a>
</fieldset>
<?php $this->endWidget(); ?>
</div>
