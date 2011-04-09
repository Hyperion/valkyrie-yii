<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Characters',
);

$this->menu=array(
    array('label'=>'Create Account', 'url'=>array('create')),
    array('label'=>'View Account', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Edit Account', 'url'=>array('edit', 'id'=>$model->id)),
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

<?php $this->widget('zii.widgets.CListView', array(
        'id' => 'characters-list',
	'dataProvider' => $mapper->search(),
	'itemView'=>'_viewChars',
)); ?>