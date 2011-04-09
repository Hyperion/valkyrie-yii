<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Edit',
);

$this->menu=array(
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'View Account', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'View Characters', 'url'=>array('characters', 'id'=>$model->id)),
);
?>

<h1>Edit Account <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>