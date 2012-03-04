<?php
$this->breadcrumbs=array(
	'Сраницы'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'Изменение',
);
?>

<h1>Изменение: <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
