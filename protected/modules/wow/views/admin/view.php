<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Realmlist', 'url'=>array('index')),
	array('label'=>'Create Realmlist', 'url'=>array('create')),
	array('label'=>'Update Realmlist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Realmlist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Realmlist', 'url'=>array('admin')),
);
?>

<h1>View Realmlist #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'port',
		'icon',
		'color',
		'timezone',
		'allowedSecurityLevel',
		'population',
		'realmbuilds',
	),
)); ?>
