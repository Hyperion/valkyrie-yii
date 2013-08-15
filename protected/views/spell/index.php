<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Spells' => 0,
);
?>

<?php $this->widget('WGridWow', array(
    'filter' => $model,
    'id'=>'spells-grid',
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://eu.media.blizzard.com/wow/icons/18/$data->iconName.jpg\');\"></span><strong>$data->spellname_loc0</strong>"
            	,array("/spell/view", "id" => $data->spellID),
            	array("class"=>"item-link"))',
            'name'=>'spellname_loc0',
            'header' => 'Name'
        ),
        array(
            'value' => '$data->levelspell',
            'name' => 'levelspell',
            'header' => 'Level'
        )
    ),
)); ?>
