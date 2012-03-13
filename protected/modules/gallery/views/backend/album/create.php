<?php
$this->breadcrumbs=array(
	'Albums'=>array('index'),
	'Create',
);
?>

<h1>Create Album</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>