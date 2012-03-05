<?php
$this->breadcrumbs=array(
    'Statistic'=>array('index'),
    'Online',
);
?>
<style>
    div.grid-view select, div.grid-view input {
        width: 100px;
    }
</style>
<?php $this->widget('BootGridView', array(
    'id'=>'characters-grid',
    'filter' => $model,
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'WowModule::charUrl($data)',
            'name'=>'name',
        ),
        'level',
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/class/$data->class.gif","Test")',
            'name'=>'class',
            'sortable'=>true,
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
            'value'=>'CHtml::image("/images/wow/icons/race/$data->race-$data->gender.gif","Test")',
            'name'=>'race',
            'sortable'=>true,
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
            'class'=>'CLocationColumn',
            'name'=>'zone',
            'sortable'=>true,
        ),
    ),
)); ?>
