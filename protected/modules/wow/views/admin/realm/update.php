<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Update Realmlist <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_databaseForm', array('model'=>$form)); ?>