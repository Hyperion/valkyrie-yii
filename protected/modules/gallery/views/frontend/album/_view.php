<div class="view">

	<b><?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->id),array('view','id'=>$model->id)); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($model->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($model->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('cover')); ?>:</b>
	<?php echo CHtml::encode($model->cover); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('visible')); ?>:</b>
	<?php echo CHtml::encode($model->visible); ?>
	<br />

</div>