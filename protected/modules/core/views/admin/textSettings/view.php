<?php
$this->breadcrumbs=array(
	'Text Settings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TextSettings', 'url'=>array('index')),
	array('label'=>'Create TextSettings', 'url'=>array('create')),
	array('label'=>'Update TextSettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TextSettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TextSettings', 'url'=>array('admin')),
);
?>

<h1>View TextSettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'language',
		'name',
		'text',
	),
)); ?>
