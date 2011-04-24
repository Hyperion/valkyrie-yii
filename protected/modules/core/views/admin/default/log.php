<?php
$this->breadcrumbs=array(
	$this->module->id,
);

?>

<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name'=>'Username',
			'value'=>'$data->user->username',
		),
		'ip',
		'time',
		'action',
	),
));