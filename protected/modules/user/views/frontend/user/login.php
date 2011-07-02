<?php
$module = $this->module;

if(Yii::app()->user->hasFlash('loginMessage')): ?>
    <div class="success"><?=Yii::app()->user->getFlash('loginMessage')?></div>
<?php endif; ?>
<p><?=Yii::t("UserModule.user", "Please fill out the following form with your login credentials:")?></p>

<div class="form">
<?=CHtml::beginForm()?>

    <?=CHtml::errorSummary($model)?>

    <div class="row">
        <?php
        if($module->loginType & UserModule::LOGIN_BY_USERNAME)
            echo CHtml::activeLabelEx($model,'username');
        if($module->loginType & UserModule::LOGIN_BY_EMAIL)
            printf ('<label for="FLogin_username">%s <span class="required">*</span></label>', Yii::t("UserModule.user", 'E-Mail address'));
?>
        <?=CHtml::activeTextField($model,'username')?>
    </div>

    <div class="row">
        <?=CHtml::activeLabelEx($model,'password')?>
        <?=CHtml::activePasswordField($model,'password')?>
    </div>

    <div class="row">
    <p class="hint">
        <?=CHtml::link(Yii::t('UserModule.user', 'Registration'), '/user/registration/registration')?>
        |
        <?/*=CHtml::link(Yii::t('UserModule.user', 'Lost Password?'), '/user/registration/recovery')*/?>
    </p>
    </div>

    <div class="row rememberMe">
        <?=CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline;'))?>
        <?=CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline;'))?>
    </div>

    <div class="row submit">
        <?=CHtml::submitButton(Yii::t('UserModule.user', 'Login'))?>
    </div>

<?=CHtml::endForm()?>
</div><!-- form -->
