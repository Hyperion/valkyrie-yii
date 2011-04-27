<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('/wow/character/simple', 'realm'=>$data->realm, 'name'=>$data->name)); ?>
	<br />
    
    <b>Realm:</b>
	<?php echo CHtml::encode($data->realm); ?>
	<br />

    <b>Guild:</b>
    <?php echo CHtml::link(CHtml::encode($data->guildName), array('/wow/guild/view', 'id'=>$data->guildId)); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('race')); ?>:</b>
	<?php echo CHtml::encode($data->raceText); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class')); ?>:</b>
	<?php echo CHtml::encode($data->classText); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

    <?php echo CHtml::link('Repair Character', array('repair', 'id'=>$data->account, 'guid'=>$data->guid)); ?>

</div>