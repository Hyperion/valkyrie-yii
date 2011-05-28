<?php
$this->breadcrumbs=array(
    'Characters'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'List Characters', 'url'=>array('index')),
    array('label'=>'Update Characters', 'url'=>array('update', 'id'=>$model->guid)),
    array('label'=>'Manage Characters', 'url'=>array('admin')),
);
?>

<div>
	<?=CHtml::link($model['name'], array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?>
</div>
<div><?=CHtml::encode(Database::$realm)?></div>
<div>Level <?=$model['level']?> <?=$model['race_text']?> <?=$model['class_text']?></div>
