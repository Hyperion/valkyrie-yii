<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

?>

<h1>Update Account <?php echo $model->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'account-edit-form',
    'enableAjaxValidation'=>false,
)); ?>

<table>
<tr>
<td colspan="2"><div class="row">
    <p class="note">
        Fields with <span class="required">*</span> are required.
    </p>
    <?php echo $form->errorSummary($model); ?>
</div></td>
</tr>
<tr>
<td width="50%"><div class="row">
    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'password'); ?>
</div></td>
<td width="50%"><div class="row">
    <?php echo $form->labelEx($model,'email'); ?>
    <?php echo $form->textField($model,'email', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'email'); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'gmlevel'); ?>
    <?php echo $form->dropDownList($model,'gmlevel', array(
        0 => 'Player',
        1 => 'Moderator',
        2 => 'Game Master',
        3 => 'Bug Tracker',
        4 => 'Admin',
        5 => 'SysOp')); ?>
    <?php echo $form->error($model,'gmlevel'); ?>
</div></td>
<td><div class="row">
    <?php echo $form->labelEx($model,'locked'); ?>
    <?php echo $form->dropDownList($model,'locked', array(
        0 => 'No',
        1 => 'Yes')); ?>
    <?php echo $form->error($model,'locked'); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'joindate'); ?>
    <?php echo $model->joindate; ?>
</div></td>
<td><div class="row">
    <?php echo $form->labelEx($model,'last_ip'); ?>
    <?php echo $model->last_ip; ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'failed_logins'); ?>
    <?php echo $model->failed_logins; ?>
</div></td>
<td><div class="row">
    <?php echo $form->labelEx($model,'active_realm_id'); ?>
    <?php echo $model->active_realm_id; ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'mutetime'); ?>
    <?php echo $form->textField($model,'mutetime', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'mutetime'); ?>
</div></td>
<td><div class="row">
    <?php echo $form->labelEx($model,'locale'); ?>
    <?php echo $form->dropDownList($model,'locale', array(
        0 => 'English',
        8 => 'Russian')); ?>
    <?php echo $form->error($model,'locale'); ?>
</div></td>
</tr>
<tr>
<td colspan="2"><div class="row">
    <?php echo CHtml::submitButton('Submit', array('class' => 'button')); ?>
</div></td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
