<div class="view">

	<b><?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->id), array('view', 'id'=>$model->id)); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('varname')); ?>:</b>
	<?php echo CHtml::encode($model->varname); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($model->title); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('field_type')); ?>:</b>
	<?php echo CHtml::encode($model->field_type); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('field_size')); ?>:</b>
	<?php echo CHtml::encode($model->field_size); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('field_size_min')); ?>:</b>
	<?php echo CHtml::encode($model->field_size_min); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('required')); ?>:</b>
	<?php echo CHtml::encode($model->required); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('match')); ?>:</b>
	<?php echo CHtml::encode($data->match); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range')); ?>:</b>
	<?php echo CHtml::encode($data->range); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('error_message')); ?>:</b>
	<?php echo CHtml::encode($data->error_message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_validator')); ?>:</b>
	<?php echo CHtml::encode($data->other_validator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default')); ?>:</b>
	<?php echo CHtml::encode($data->default); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<?php echo CHtml::encode($data->visible); ?>
	<br />

	*/ ?>

</div>