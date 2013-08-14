<?php
$this->breadcrumbs=array(
	'Game'                    => array('/wow'),
    'Statistic'				  => array('/wow/statistic'),
    Database::$realm.' @ PvP'
);
?>
<?php $this->widget('BootGridView', array(
    'filter' => $model,
    'dataProvider'=>$model->search(40),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'WowModule::charUrl($data)',
            'name'=>'name',
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/faction/$data->faction.gif")',
            'name'=>'faction',
            'sortable'=>false,
            'filter' => Character::itemAlias('faction'),
        ),
        array(
            'name'=>'honor.thisWeek_cp',
        ),
        'honor_standing',
    ),
)); ?>
