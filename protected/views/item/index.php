<?php
$this->breadcrumbs=array(
    'Items' => array('/item'),
);
if(isset($model->class))
    $this->breadcrumbs[$model->class_text] = array("/item?classId={$model->class}");
if(isset($model->subclass))
    $this->breadcrumbs[$model->subclass_text] = array("/item?classId={$model->class}&subClassId={$model->subclass}");
if(isset($model->InventoryType) && $model->class == $model::ITEM_CLASS_ARMOR)
    $this->breadcrumbs[$model::itemAlias('invtype', $model->InventoryType)] = array("/item?classId={$model->class}&subClassId={$model->subclass}&invType={$model->InventoryType}");

    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('item-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
    <div class="table-options">
        <h3><?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?></h3>
        <div class="search-form" style="display:none">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form -->
    </div>

        
<?php $this->widget('WGridWow', array(
    'dataProvider'=>$model->search(),
    'enableSorting'=>true,
    'id' => 'item-grid',
    'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"<span class=\"icon-frame frame-18\" style=\"background-image: url(\'http://eu.media.blizzard.com/wow/icons/18/$data->icon.jpg\');\"></span><strong>$data->name</strong>"
            	,array("/item/view", "id" => $data->entry),
            	array("class"=>"item-link color-q$data->Quality"))',
            'name'=>'name',
        ),
        'ItemLevel',
        'RequiredLevel',
    ),
)); ?>
