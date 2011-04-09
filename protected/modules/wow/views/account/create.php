<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
    array('label'=>'Recovery Password', 'url'=>array('recowery')),
);
?>

<h1>Create Account</h1>

<?php echo $this->renderPartial('_register', array('model'=>$form)); ?>