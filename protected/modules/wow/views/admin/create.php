<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Realmlist', 'url'=>array('index')),
	array('label'=>'Manage Realmlist', 'url'=>array('admin')),
);
?>

<h1>Create Realmlist</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>