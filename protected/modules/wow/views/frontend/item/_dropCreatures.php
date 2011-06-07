<div class="related-content" id="related-dropCreatures"> 
	<div class="filters inline"> 
		<div class="keyword"> 
			<input id="filter-name-dropCreatures" type="text" class="input filter-name" data-filter="row" maxlength="25" title="Фильтр" value="Фильтр" /> 
		</div> 
		<span class="clear"><!-- --></span> 
	</div> 
 
<?php $this->widget('WStaticGridWow', array(
    'id'=>'dropCreatures-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
		array(
			'type' => 'raw',
			'name' => 'name',
			'value' => 'CHtml::link(
				"<strong>{$data[\'name\']}</strong>",
				array("/wow/creature/view", "id" => $data[\'entry\']))',
		),
		array(
			'name' => 'type',
			'value' => 'CreatureTemplate::itemAlias("type",$data["type"])',
		),
		array(
			'name' => 'level',
			'value' => '($data["minlevel"] == $data["maxlevel"]) ? $data["maxlevel"] : $data["minlevel"]." - ".$data["maxlevel"]',
		),
		'percent',
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
