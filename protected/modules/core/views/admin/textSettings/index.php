<?php
$this->breadcrumbs=array(
	'Text Settings',
);

$this->menu=array(
	array('label'=>'Create TextSettings', 'url'=>array('create')),
	array('label'=>'Manage TextSettings', 'url'=>array('admin')),
);
?>

<h1>Text Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
