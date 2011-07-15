<div class="dashboard-form" id="change-password">
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>false,
)); ?>
<h4>Смена пароля</h4>
<p>Используйте эту форму для смены пароля.</p>
<div class="form-row required">
    <?=$form->labelEx($model,'oldPassword')?>
    <?=$form->passwordField($model,'oldPassword')?>
    <?=$form->error($model,'oldPassword')?>
</div>
<div class="form-row required">
    <?php echo $form->labelEx($model,'newPassword'); ?>
    <?php echo $form->passwordField($model,'newPassword'); ?>
    <?php echo $form->error($model,'newPassword'); ?>
</div>
<div class="form-row required">
    <?php echo $form->labelEx($model,'confirmNewPassword', array('class' => 'label-full')); ?>
    <?php echo $form->passwordField($model,'confirmNewPassword'); ?>
    <?php echo $form->error($model,'confirmNewPassword'); ?>
</div>
<fieldset class="ui-controls " >
<button
class="ui-button button1"
type="submit"
tabindex="1">
<span>
<span>Сменить пароль</span>
</span>
</button>
<a class="ui-cancel " href="#" onclick="DashboardForm.hide($('#change-password')); return false;" tabindex="1">
<span>Отмена</span>
</a>
</fieldset>
<p>Заглавные и строчные символы не различаются.</p>
<?php $this->endWidget(); ?>
</div>
