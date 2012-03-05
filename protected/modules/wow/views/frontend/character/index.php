<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Characters',
);
?>

<?php $this->widget('WGridWow', array(
    'id'=>'characters-grid',
    'dataProvider'=>$model->search(true),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\">".CHtml::image("/images/wow/2d/avatar/$data->race-$data->gender.jpg", "", array("height" => 18, "width" => 18))."</span><strong>$data->name</strong>"
            	,array("/wow/character/view/", "realm" => Database::$realm, "name" => $data->name),
            	array("class"=>"item-link color-c$data->class"))',
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
