<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Account', 'url'=>array('create')),
    array('label'=>'Ban Account', 'url'=>array('ban')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Accounts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'account-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'gmlevel',
		'email',
		'joindate',
		'last_ip',
		'failed_logins',
		'locked',
		'last_login',
		'active_realm_id',
		'mutetime',
		'locale',
		'loc_selection',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
