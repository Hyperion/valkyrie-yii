<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

?>

<h1>Update Account <?php echo $model->id; ?></h1>

<?php $form=$this->beginWidget('BootActiveForm', array(
    'id'=>'account-edit-form',
    'enableAjaxValidation'=>false,
)); ?>

<table width="100%">
<tr>
<td colspan="2">
    <p class="note">
        Fields with <span class="required">*</span> are required.
    </p>
    <?php echo $form->errorSummary($model); ?>
</td>
</tr>
<tr>
<td width="50%">
    <?php echo $form->passwordFieldRow($model,'password'); ?>
</td>
<td width="50%">
    <?php echo $form->textFieldRow($model,'email'); ?>
</td>
</tr>
<tr>
<td>
    <?php echo $form->dropDownListRow($model,'gmlevel', array(
        0 => 'Player',
        1 => 'Moderator',
        2 => 'Game Master',
        3 => 'Bug Tracker',
        4 => 'Admin',
        5 => 'SysOp')); ?>
</td>
<td>
    <?php echo $form->dropDownList($model,'locked', array(
        0 => 'No',
        1 => 'Yes')); ?>
</td>
</tr>
<tr>
<td>
    <?php echo $form->labelEx($model,'joindate'); ?>
    <?php echo $model->joindate; ?>
</td>
<td>
    <?php echo $form->labelEx($model,'last_ip'); ?>
    <?php echo $model->last_ip; ?>
</td>
</tr>
<tr>
<td>
    <?php echo $form->labelEx($model,'failed_logins'); ?>
    <?php echo $model->failed_logins; ?>
</td>
<td>
    <?php echo $form->labelEx($model,'active_realm_id'); ?>
    <?php echo $model->active_realm_id; ?>
</td>
</tr>
<tr>
<td>
    <?php echo $form->textFieldRow($model,'mutetime'); ?>
</td>
<td>
    <?php echo $form->dropDownListRow($model,'locale', array(
        0 => 'English',
        8 => 'Russian')); ?>
</td>
</tr>
<tr>
<td colspan="2"><div class="form-actions">
    <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary')); ?>
</div></td>
</tr>
</table>

<?php $this->endWidget(); ?>
