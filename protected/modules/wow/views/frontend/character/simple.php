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

<div class="profile-info-anchor">
    <div class="profile-info">
    <div class="name">
    	<?=CHtml::link($model['name'], array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?></div>
        <span class="realm tip" id="profile-info-realm" data-battlegroup=""><?=CHtml::encode(Database::$realm)?></span>
    </div>
    </div>
</div>
