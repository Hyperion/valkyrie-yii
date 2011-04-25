<?php
$this->breadcrumbs=array(
	'Realmlists',
);

$this->menu=array(
	array('label'=>'Create Realmlist', 'url'=>array('create')),
	array('label'=>'Manage Realmlist', 'url'=>array('admin')),
);
?>

<h1>Realmlist Info</h1>

<?php echo $this->renderPartial('_realmlistForm', array('model'=>$form)); ?>
