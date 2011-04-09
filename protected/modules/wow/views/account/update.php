<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'Create Account', 'url'=>array('create')),
    array('label'=>'Manage Accounts', 'url'=>array('admin')),
    array('label'=>'Ban Account By Id', 'url'=>array('ban', 'id'=>$model->id)),
    array('label'=>'Ban Account By Last Ip', 'url'=>array('ban', 'ip'=>$model->last_ip)),
);
?>

<h1>Update Account <?php echo $model->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-edit-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'gmlevel'); ?>
        <?php echo $form->dropDownList($model,'gmlevel', array(
                    '0' => 'Player',
                    '1' => 'Moderator',
                    '2' => 'Game Master',
                    '3' => 'Bug Tracker',
                    '4' => 'Admin',
                    '5' => 'SysOp')); ?>
        <?php echo $form->error($model,'gmlevel'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'locked'); ?>
        <?php echo $form->dropDownList($model,'locked', array(
                    '0' => 'No',
                    '1' => 'Yes')); ?>
        <?php echo $form->error($model,'locked'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'joindate'); ?>
		<?php echo $model->joindate; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_ip'); ?>
		<?php echo $model->last_ip; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'failed_logins'); ?>
		<?php echo $model->failed_logins; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active_realm_id'); ?>
        <?php echo $model->active_realm_id; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mutetime'); ?>
		<?php echo $form->textField($model,'mutetime'); ?>
		<?php echo $form->error($model,'mutetime'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'locale'); ?>
        <?php echo $form->dropDownList($model,'locale', array(
                    '0' => 'English',
                    '8' => 'Russian')); ?>
        <?php echo $form->error($model,'locale'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->