<?php
$this->breadcrumbs=array(
	'Albums',
);

$this->menu=array(
	array('label'=>'Create Album','url'=>array('create')),
	array('label'=>'Manage Album','url'=>array('admin')),
);
?>

<h1>Albums</h1>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
