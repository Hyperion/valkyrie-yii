<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('class' => 'text-input medium-input')); ?>
    </div>

    <div class="row">
        <?php echo CHtml::submitButton('Search', array('class' => 'button')); ?>
    </div>

<?php $this->endWidget(); ?>

</div>
