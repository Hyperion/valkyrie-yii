<?php $this->widget('BootGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
		array(
			'type' => 'raw',
			'name' => 'Name',
			'value' => 'CHtml::link(
				"<strong>{$data[\'name\']}</strong>",
				array("/wow/creature/view", "id" => $data[\'entry\']))',
		),
		array(
			'name' => 'Type',
			'value' => 'CreatureTemplate::itemAlias("type",$data["type"])',
		),
		array(
			'name' => 'Level',
			'value' => '($data["minlevel"] == $data["maxlevel"]) ? $data["maxlevel"] : $data["minlevel"]." - ".$data["maxlevel"]',
		),
    ),
)); ?>
