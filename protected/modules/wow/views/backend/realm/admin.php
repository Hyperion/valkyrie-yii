<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Realmlist', 'url'=>array('index')),
	array('label'=>'Create Realmlist', 'url'=>array('create')),
);

?>

<h1>Manage Realmlists</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'realmlist-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'address',
		'port',
		'timezone',
		'allowedSecurityLevel',
		'population',
		'realmbuilds',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
