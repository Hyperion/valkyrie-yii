<?php
$this->breadcrumbs=array(
	'Realmlists',
);

$this->menu=array(
	array('label'=>'Create Realmlist', 'url'=>array('create')),
	array('label'=>'Manage Realmlist', 'url'=>array('admin')),
);
?>

<h1>Realmlists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
