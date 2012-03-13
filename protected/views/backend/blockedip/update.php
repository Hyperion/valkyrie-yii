<?php
$this->breadcrumbs=array(
	'Черный список IP'=>array('admin'),
	$model->mask=>array('view','id'=>$model->id),
	'Изменение',
);
?>

<h1>Изменение: <?php echo $model->mask; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
