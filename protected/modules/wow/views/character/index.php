<?php
$this->breadcrumbs=array(
    'Characters',
);

$this->menu=array(
    array('label'=>'Manage Characters', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.CListView.update('characters-list', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Characters</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'characters-list',
    'dataProvider' => $mapper->search(),
    'itemView'=>'_view',
)); ?>