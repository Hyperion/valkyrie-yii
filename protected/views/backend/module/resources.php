<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'articles-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'resource',
		'description',
		array(
			'class'=>'CButtonColumn',
            'buttons'=>array(
                'install'=>array(
                    'label'=>'Install',
                    'visible'=>'($data[need_install] == 1)?true:false',
                    'url'=> 'Yii::app()->createUrl("admin/core/module/install", array("resource"=>$data[resource]))',
                ),
                'uninstall'=>array(
                    'label'=>'Uninstall',
                    'visible'=>'($data[need_install] == 0)?true:false',
                    'url'=> 'Yii::app()->createUrl("admin/core/module/uninstall", array("resource"=>$data[resource]))',
                ),
            ),
            'template'=>'{install}{uninstall}',
 		),
 
	),
));