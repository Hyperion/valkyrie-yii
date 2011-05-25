<?php
$this->breadcrumbs=array(
	'Realmlists'=>array('index'),
	'Update',
);

?>

<h1>Update Realmlist <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>