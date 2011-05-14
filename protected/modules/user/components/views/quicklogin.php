	<?php echo CHtml::beginForm(array('/user/auth')); 
    
    $link = '//' .
    Yii::app()->controller->uniqueid .
    '/' . Yii::app()->controller->action->id;
    echo CHtml::hiddenField('quicklogin', $link);
    ?>
    
        <?=CHtml::errorSummary($model)?>
        
        <div class="row">
            <?=CHtml::activeLabelEx($model,'username')?>
            <?=CHtml::activeTextField($model,'username', array('size' => 10))?>
        </div>
        
        <div class="row" style="padding-top:12px;">
            <?=CHtml::activeLabelEx($model,'password')?>
            <?=CHtml::activePasswordField($model,'password', array('size' => 10))?>
        </div>
        
        <div class="row" style="font-size:10px;">
			<?=CHtml::link(Yii::t('UserModule.user', 'Registration'), array('//user/registration/registration'))?> 
			<?=CHtml::link(Yii::t('UserModule.user', 'Lost Password?'), array('//user/registration/recovery'))?>
		</div>

    	<div class="row rememberMe">
			<?=CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline;'))?>
			<?=CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline;'))?>
		</div>
    
        <div class="row submit">
            <?=CHtml::submitButton(Yii::t('UserModule.user', 'Login'))?>
        </div>
        
    <?php echo CHtml::endForm(); ?>
