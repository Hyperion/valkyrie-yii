<div class="related-content" id="related-vendors"> 
 
<?php $this->widget('WStaticGridWow', array(
    'id'=>'dropCreatures-grid',
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
	<script type="text/javascript"> 
	//<![CDATA[
		Wiki.related['dropCreatures'] = new WikiRelated('dropCreatures', {
			paging: true,
			totalResults: <?=$dataProvider->totalItemCount?>,
			results: 50,
			column: 0
		});
	//]]>
	</script> 
</div> 
