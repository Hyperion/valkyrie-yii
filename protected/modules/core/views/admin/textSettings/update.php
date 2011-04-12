<?php
$this->breadcrumbs=array(
	'Text Settings'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TextSettings', 'url'=>array('index')),
	array('label'=>'Create TextSettings', 'url'=>array('create')),
	array('label'=>'View TextSettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TextSettings', 'url'=>array('admin')),
);
?>

<h1>Update TextSettings <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>