<div class="related-content" id="related-disenchantItems">
    <div class="filters inline">
        <div class="keyword">
            <input id="filter-name-disenchantItems" type="text" class="input filter-name" data-filter="row" maxlength="25" title="Фильтр" value="Фильтр" />
        </div>
        <span class="clear"><!-- --></span>
    </div>

    <?php $this->widget('WStaticGridWow', array(
        'id'=>'disenchantItems-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            array(
                'type' => 'raw',
                'name' => 'Name',
                'value'=>'CHtml::link(
                "<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://media.blizzard.com/wow/icons/18/".$data["icon"].".jpg\');\"></span><strong>".$data["name"]."</strong>"
                ,array("/item/view", "id" => $data["entry"]),
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
    <script type="text/javascript">
        //<![CDATA[
        Wiki.related['disenchantItems'] = new WikiRelated('disenchantItems', {
            paging: true,
            totalResults: <?=$dataProvider->totalItemCount?>,
            results: 50,
            column: 0
        });
        //]]>
    </script>
</div> 