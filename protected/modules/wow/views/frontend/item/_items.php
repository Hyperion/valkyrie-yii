<div> 

<?php $this->widget('BootGridView', array(
    'id'=>'disenchantItems-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
		array(
			'type' => 'raw',
			'name' => 'Name',
			'value'=>'CHtml::link(
                "<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://eu.media.blizzard.com/wow/icons/18/".$data["icon"].".jpg\');\"></span><strong>".$data["name"]."</strong>"
                ,array("/wow/item/view", "id" => $data["entry"]),
                array("class"=>"item-link color-q".$data["Quality"]))',

		),
		array(
			'name' => 'Level',
			'value' => '$data["itemLevel"]',
		),
		array(
			'name' => 'Count',
			'value' => '($data["mincount"] == $data["maxcount"]) ? $data["mincount"] : $data["mincount"]." - ".$data["maxcount"]',
		),
		array(
			'name' => 'Drop Chance',
			'value' => 'round($data["percent"], 2)." %"'
		),
    ),
)); ?>
</div> 
