<?php
$this->breadcrumbs=array(
	'Черный список IP'=>array('admin'),
	'Создать',
);
?>

<h1>Добавление IP в черный список</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
