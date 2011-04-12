<?php
$this->breadcrumbs=array(
	'Text Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TextSettings', 'url'=>array('index')),
	array('label'=>'Manage TextSettings', 'url'=>array('admin')),
);
?>

<h1>Create TextSettings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>