<?php foreach($profile->loadProfileFields() as $field): ?>
<div class="row">

<?php if($field->hint): ?>
<div class="hint"><?=$field->hint?></div>
<?php endif; ?>
<?=CHtml::activeLabelEx($profile, $field->varname)?>
<?php if ($field->field_type=="TEXT"): ?>
<?=CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50))?>
<?php elseif($field->field_type == "DROPDOWNLIST"): ?>
<?=CHtml::activeDropDownList(
	$profile,
	$field->varname, 
	CHtml::listData(
		CActiveRecord::model(ucfirst($field->varname))->findAll(),
		'id',
		$field->related_field_name
	)
)?>
<?php else: ?>
<?=CHtml::activeTextField(
	$profile,
	$field->varname,
	array(
		'size'=>(($field->field_size_min)?$field->field_size_min:25),
		'maxlength'=>(($field->field_size)?$field->field_size:255)
	)
)?>
<?php endif; ?>
<?=CHtml::error($profile,$field->varname)?>
</div>
<?php endforeach ?>
