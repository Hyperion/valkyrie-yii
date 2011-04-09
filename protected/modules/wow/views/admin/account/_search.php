<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gmlevel'); ?>
        <?php echo $form->dropDownList($model,'gmlevel', array(
                    '0' => 'Player',
                    '1' => 'Moderator',
                    '2' => 'Game Master',
                    '3' => 'Bug Tracker',
                    '4' => 'Admin',
                    '5' => 'SysOp')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_ip'); ?>
		<?php echo $form->textField($model,'last_ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'failed_logins'); ?>
		<?php echo $form->textField($model,'failed_logins'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'locked'); ?>
        <?php echo $form->dropDownList($model,'locked', array(
                    '0' => 'No',
                    '1' => 'Yes')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_login'); ?>
		<?php echo $form->textField($model,'last_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active_realm_id'); ?>
		<?php echo $form->textField($model,'active_realm_id'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'locale'); ?>
        <?php echo $form->dropDownList($model,'locale', array(
                    '0' => 'English',
                    '8' => 'Russian')); ?>
    </div>

	<div class="row">
		<?php echo $form->label($model,'loc_selection'); ?>
        <?php echo $form->dropDownList($model,'loc_selection', array(
                    '0' => 'No',
                    '1' => 'Yes')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->