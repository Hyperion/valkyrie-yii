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
                'name' => 'Name',
                'value' => 'CHtml::link(
				"<strong>{$data[\'name\']}</strong>",
				array("/creature/view", "id" => $data[\'entry\']))',
            ),
            array(
                'name' => 'Type',
                'value' => 'CreatureTemplate::itemAlias("type",$data["type"])',
            ),
            array(
                'name' => 'Level',
                'value' => '($data["minlevel"] == $data["maxlevel"]) ? $data["maxlevel"] : $data["minlevel"]." - ".$data["maxlevel"]',
            ),
            array(
                'name' => 'Drop Chance',
                'value' => 'round($data["percent"], 2)." %"'
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