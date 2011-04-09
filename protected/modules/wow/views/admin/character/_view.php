<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->guid)); ?>
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

    <b>Guild:</b>
    <?php echo CHtml::link(CHtml::encode($data->guildName), array('/wow/guild', 'id'=>$data->guildId)); ?>
    <br />

</div>