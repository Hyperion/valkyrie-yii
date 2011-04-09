<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Edit Account', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'gmlevel',
		'email',
		'joindate',
		'last_ip',
		'failed_logins',
		'locked',
		'last_login',
		'active_realm_id',
		'mutetime',
		'locale',
		'loc_selection',
	),
)); ?>
