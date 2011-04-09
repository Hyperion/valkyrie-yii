<div class="view">

	<?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->id)); ?>
    <br />
    <?php echo CHtml::link('Show characters', array('characters', 'id'=>$data->id)); ?>

</div>