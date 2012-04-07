<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('admin'),
	'Update',
);

?>

<h1>Update Realmlist <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>