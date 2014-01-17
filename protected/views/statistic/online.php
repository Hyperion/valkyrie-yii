<?php
$this->breadcrumbs=array(
    'Statistic'=>array('/statistic'),
    'Online' => array('/statistic/online'),
);
?>
<style>
    div.grid-view select, div.grid-view input {
        width: 100px;
    }
</style>
<?php $this->widget('WGridWow', array(
    'id'=>'characters-grid',
    'filter' => $model,
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'Wow::charUrl($data)',
            'name'=>'name',
        ),
        'level',
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/class/$data->class_id.gif","Test")',
            'name'=>'class_id',
            'sortable'=>true,
            'filter' => Character::itemAlias('class'),
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/race/$data->race-$data->gender.gif","Test")',
            'name'=>'race',
            'sortable'=>true,
            'filter' => Character::itemAlias('race'),
        ),
        array(
            'class'=>'CLocationColumn',
            'name'=>'zone',
            'sortable'=>true,
        ),
    ),
)); ?>
