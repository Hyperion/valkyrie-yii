<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<table>
<tr>
<td width="50%"><div class="row">
    <?php echo $form->label($model,'username'); ?>
    <?php echo $form->textField($model,'username', array('class' => 'text-input large-input')); ?>
</div></td>
<td width="50%"><div class="row">
    <?php echo $form->label($model,'gmlevel'); ?>
    <?php echo $form->dropDownList($model,'gmlevel', array(
        '0' => 'Player',
        '1' => 'Moderator',
        '2' => 'Game Master',
        '3' => 'Bug Tracker',
        '4' => 'Admin',
        '5' => 'SysOp')); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->label($model,'email'); ?>
    <?php echo $form->textField($model,'email', array('class' => 'text-input large-input')); ?>
</div></td>
<td><div class="row">
    <?php echo $form->label($model,'last_ip'); ?>
    <?php echo $form->textField($model,'last_ip', array('class' => 'text-input large-input')); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->label($model,'failed_logins'); ?>
    <?php echo $form->textField($model,'failed_logins', array('class' => 'text-input large-input')); ?>
</div></td>
<td><div class="row">
    <?php echo $form->label($model,'locked'); ?>
    <?php echo $form->dropDownList($model,'locked', array(
        '0' => 'No',
        '1' => 'Yes')); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->label($model,'last_login'); ?>
    <?php echo $form->textField($model,'last_login', array('class' => 'text-input large-input')); ?>
</div></td>
<td><div class="row">
    <?php echo $form->label($model,'active_realm_id'); ?>
    <?php echo $form->textField($model,'active_realm_id', array('class' => 'text-input large-input')); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'locale'); ?>
    <?php echo $form->dropDownList($model,'locale', array(
        '0' => 'English',
        '8' => 'Russian')); ?>
</div></td>
<td><div class="row">
    <?php echo $form->label($model,'loc_selection'); ?>
    <?php echo $form->dropDownList($model,'loc_selection', array(
        '0' => 'No',
        '1' => 'Yes')); ?>
</div></td>
</tr>
<tr>
<td colspan="2"><div class="row">
    <?php echo CHtml::submitButton('Search', array('class' => 'button')); ?>
</div></td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
