<?php
$this->breadcrumbs=array(
    'Characters'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List Characters', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('characters-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Characters</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'characters-grid',
    'dataProvider'=>$mapper->search(),
    'filter'=>$model,
    'columns'=>array(
        'name',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
