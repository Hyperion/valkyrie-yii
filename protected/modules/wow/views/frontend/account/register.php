<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    'Create',
);

?>
<div class="add-game">
    <div>
        <div class="section-title">
            <h2 class="subcategory">Управление игрой</h2>
            <h3 class="headline">Регистрация аккаунта</h3>
        </div>
        <div class="section-box border-5"  style="margin-left: 30%; margin-right: 30%;">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'register-account-form',
    'enableAjaxValidation'=>false,
)); ?>
    <p class="caption">
        <label for="FAccountCreate_username">Введите логин</label>
    </p>
    <p class="simple-input required">
        <?=$form->textField($model,'username', array('class' => "input border-5 glow-shadow-2 inline-input", 'style' => 'width: 95%;'))?>
        <?=$form->error($model,'username')?>
    </p>
    <p class="caption">
        <label for="FAccountCreate_password">Введите пароль</label>
    </p>
    <p class="simple-input required">
        <?=$form->passwordField($model,'password', array('class' => "input border-5 glow-shadow-2 inline-input", 'style' => 'width: 95%'))?>
        <?=$form->error($model,'password')?>
    </p>
        <p class="caption">
        <label for="FAccountCreate_confirmPassword">Повторите пароль</label>
    </p>
    <p class="simple-input required">
        <?=$form->passwordField($model,'confirmPassword', array('class' => "input border-5 glow-shadow-2 inline-input", 'style' => 'width: 95%'))?>
        <?=$form->error($model,'confirmPassword')?>
    </p>
        <p class="caption">
        <label for="FAccountCreate_locale">Выберите локализацию</label>
    </p>
    <p class="simple-input required">
        <?php echo $form->dropDownList($model,'locale', array(
            '0' => 'English',
            '8' => 'Russian'),
        array('class' => 'input border-5 glow-shadow-2')); ?>
        <?php echo $form->error($model,'locale'); ?>
    </p>
    <p>Прежде чем применять Русскую локализацию, положите папку <a href="http://valkyrie-wow.com/Fonts.zip">Fonts</a> в корневую папку с игрой! После каждой смены локализации удаляйте папку WDB(кеш)!</p>
    <fieldset style="text-align: center;">
        <button class="ui-button button1" type="submit">
            <span>
            <span>Создать игровой аккаунт</span>
            </span>
        </button>
    </fieldset>
<?php $this->endWidget(); ?>
        </div>
    </div>
</div>
