<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Управление',
);\n";
?>

?>

<h1>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>
<div class="bloc">
    <div class="title"><?php echo $this->pluralize($this->class2name($this->modelClass)); ?></div>
    <div class="content">
<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
    'pagerCssClass' => 'pagination',
    'pager' => array(
        'class'=>'CLinkPager',
        'cssFile' => false,
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',
        'header' => false,
    ),
    'cssFile' => false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
            'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/edit.png',
            'viewButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/view.png',
            'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/delete.png',
            'header' => 'Actions',
		),
	),
)); ?>
    </div>
</div>
