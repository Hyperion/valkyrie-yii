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
            <h3 class="headline">Добавление аккаунта</h3>
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
    <fieldset style="text-align: center;">
        <button class="ui-button button1" type="submit">
            <span>
            <span>Прикрепить игровой аккаунт</span>
            </span>
        </button>
    </fieldset>
<?php $this->endWidget(); ?>
        </div>
    </div>
</div>
