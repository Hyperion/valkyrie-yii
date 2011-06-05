<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Items'=>array('/wow/item'),
);
if(isset($model->class))
    $this->breadcrumbs[$model->class_text] = array("/wow/item?classId={$model->class}");
if(isset($model->subclass))
    $this->breadcrumbs[$model->subclass_text] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}");
if(isset($model->InventoryType))
    $this->breadcrumbs[$model::itemAlias('invtype', $model->InventoryType)] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}&invType={$model->InventoryType}");
?>

<?php $this->widget('WGridWow', array(
    'id'=>'items-grid',
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://eu.media.blizzard.com/wow/icons/18/$data->icon.jpg\');\"></span><strong>$data->name</strong>"
            	,array("/wow/item/view", "id" => $data->entry),
            	array("class"=>"item-link color-q$data->Quality"))',
            'name'=>'name',
        ),
        'ItemLevel',
        'RequiredLevel',
    ),
)); ?>
