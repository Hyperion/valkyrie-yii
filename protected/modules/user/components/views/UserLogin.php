<?php if(Yii::app()->user->isGuest) : ?>

<?php
if($form->getErrors() != null) {
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
     'id'=>'userloginwidget',
     'options'=>array(
         'title'=>'User Login Errors',
         'autoOpen'=>true,
         'modal'=>true,
         'width'=>350,
     ),
   ));
}else{
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
     'id'=>'userloginwidget',
     'options'=>array(
         'title'=>'User Login',
         'autoOpen'=>false,
         'modal'=>true,
         'width'=>300,
     ),
   ));
}
?>

<?php echo CHtml::beginForm(Yii::app()->user->loginUrl); ?>

<p>
<?php echo CHtml::activeLabel($form,'username'); ?>
<?php echo CHtml::activeTextField($form,'username') ?>
</p>
<p>
<?php echo CHtml::activeLabel($form,'password'); ?>
<?php echo CHtml::activePasswordField($form,'password') ?>
</p>
<p>
<?php echo CHtml::activeCheckBox($form,'rememberMe'); ?>
<?php echo CHtml::activeLabel($form,'rememberMe'); ?>
</p>
<?php echo CHtml::submitButton('Submit'); ?>

<?php echo CHtml::error($form,'password'); ?>
<?php echo CHtml::error($form,'username'); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>
