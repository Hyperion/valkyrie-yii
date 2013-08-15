<?php
$this->breadcrumbs=array(
    'Characters' => '',
);
?>

<?php $this->widget('WGridWow', array(
    'id'=>'characters-grid',
    'dataProvider'=>$model->search(true),
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
            'value'=>'CHtml::image("/images/wow/icons/class/$data->class.gif")',
            'name'=>'class',
            'sortable'=>true,
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/race/$data->race-$data->gender.gif")',
            'name'=>'race',
            'sortable'=>true,
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::image("/images/wow/icons/faction/$data->faction.gif")',
            'name'=>'faction',
            'sortable'=>false,
        ),
		array(
			'name' => 'realm',
			'sortable' => false,
		),
    ),
)); ?>
