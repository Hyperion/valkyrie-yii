<?php
$this->breadcrumbs=array(
    'Statistic'=>array('index'),
    'PvP',
);
?>

<?php $this->widget('WGridWow', array(
    'filter' => $model,
    'dataProvider'=>$model->search(40),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\">".CHtml::image("/images/wow/2d/avatar/$data->race-$data->gender.jpg", "", array("height" => 18, "width" => 18))."</span><strong>$data->name</strong>"
            	,array("/wow/character/simple/", "realm" => Database::$realm, "name" => $data->name),
            	array("class"=>"item-link color-c$data->class"))',
            'name'=>'name',
        ),
        'level',
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/class/$data->class.gif")',
            'name'=>'class',
            'filter' => array(
                1 => 'Warrior',
                2 => 'Paladin', 
                3 => 'Hunter',
                4 => 'Rogue',
                5 => 'Priest',
                7 => 'Shaman',
                8 => 'Mage',
                9 => 'Warlock',
                11 => 'Druid', 
                ),
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/race/$data->race-$data->gender.gif")',
            'name'=>'race',
            'filter' => array(
                1 => 'Human',
                2 => 'Orc', 
                3 => 'Dwarf',
                4 => 'Night Elf',
                5 => 'Undead',
                6 => 'Tauren',
                7 => 'Gnome',
                8 => 'Troll',
                ),
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/faction/$data->faction.gif")',
            'name'=>'faction',
            'sortable'=>false,
            'filter' => array(
                0 => 'Alliance',
                1 => 'Horde',
                ),
        ),
        array(
            'name'=>'honor.hk',
            'sortable'=>false,
        ),
        'honor_standing',
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/rank/PvPRank0$data->honor_highest_rank.png", "", array("height" => 18, "width" => 18))',
            'name'=>'honor_highest_rank',
            'sortable'=>true,
            'filter'=>false,
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/rank/PvPRank0$data->honorRank.png", "", array("height" => 18, "width" => 18))',
            'name'=>'honor_rank_points',
            'sortable'=>true,
            'filter'=>false,
        ),
        array(
            'name' => 'honor.thisWeek_cp',
            'sortable' => false,
        ),
        array(
            'name' => 'honor.thisWeek_kills',
            'sortable' => false,
        ),
    ),
)); ?>