<?php
$this->breadcrumbs=array(
	'Game'                    => array('/wow'),
    'Statistic'				  => array('/wow/statistic'),
);
if($current)
    $this->breadcrumbs[Database::$realm.' @ PvP Current'] = array('/wow/statistic/pvpcurrent', 'realm' => Database::$realm);
else
    $this->breadcrumbs[Database::$realm.' @ PvP'] = array('/wow/statistic/pvp', 'realm' => Database::$realm);    
?>
<style>
    select {
        width: 75px;
    }
</style>
<?php $this->widget('BootGridView', array(
    'filter' => $model,
    'dataProvider'=>$model->search(40),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link($data->name, array("/wow/character/simple/", "realm" => Database::$realm, "name" => $data->name))',
            'name'=>'name',
        ),
        'level',
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/class/$data->class.gif")',
            'name'=>'class',
            'filter' => Character::itemAlias('classes'),
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/race/$data->race-$data->gender.gif")',
            'name'=>'race',
            'filter' => Character::itemAlias('races'),
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/faction/$data->faction.gif")',
            'name'=>'faction',
            'sortable'=>false,
            'filter' => Character::itemAlias('factions'),
        ),
        array(
            'name'=>'honor.hk',
        ),
        array(
            'name'=>'honor.thisWeek_cp',
        ),
                array(
            'name'=>'honor.lastWeek_cp',
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
        /*array(
            'name' => 'honor.thisWeek_cp',
        ),
        array(
            'name' => 'honor.thisWeek_kills',
        ),*/
    ),
)); ?>
