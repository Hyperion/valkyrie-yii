<?php
$this->breadcrumbs=array(
	'Страницы'=>array('admin'),
	'Создать',
);
?>

<h1>Создание страницы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
