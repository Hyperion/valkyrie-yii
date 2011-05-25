<?php
$this->breadcrumbs=array(
	'News'=>array('index'),
	CHtml::encode($model->{'title_'.Yii::app()->language}),
);

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'Update News', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete News', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
?>

<h3 class="blog-title"><?php echo CHtml::encode($model->{'title_'.Yii::app()->language}); ?></h3>
<div class="by-line">
    <?php echo CHtml::link(CHtml::encode($model->author), array('/wow/search', 'f'=>'article', 'a' =>CHtml::encode($model->author))); ?>
    <span class="spacer">//</span> <?php echo date('F j, Y',$model->postdate); ?>
    <a class="comments-link" href="#comments"><?php echo CHtml::encode($model->commentCount); ?></a>
    <span class="clear"><!-- --></span>
</div>
<?php if($model->header_image != ''): ?>
<div class="header-image">
    <img alt="<?php echo CHtml::encode($model->{'title_'.Yii::app()->language}); ?>" src="http://eu.media1.battle.net/cms/blog_header/<?php echo CHtml::encode($model->header_image); ?>" />
</div>
<?php endif; ?>
<div class="detail"><div>
    <?php echo $model->{'text_'.Yii::app()->language}; ?>
</div>
</div>
