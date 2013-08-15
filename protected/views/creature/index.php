<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Items',
);
?>

<?php $this->widget('WGridWow', array(
    'id'=>'creatures-grid',
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://eu.media.blizzard.com/wow/icons/18/$data->icon.jpg\');\"></span><strong>$data->name</strong>"
            	,array("/creature/view", "id" => $data->entry),
            	array("class"=>"item-link"))',
            'name'=>'name',
        ),
        'ItemLevel',
        'RequiredLevel',
    ),
)); ?>
