<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Realmlist', 'url'=>array('index')),
	array('label'=>'Create Realmlist', 'url'=>array('create')),
	array('label'=>'View Realmlist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Realmlist', 'url'=>array('admin')),
);
?>

<h1>Update Realmlist <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>