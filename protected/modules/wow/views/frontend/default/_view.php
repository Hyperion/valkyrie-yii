<div class="view">

	<h3><?php echo CHtml::link(CHtml::encode($data->{'title_'.Yii::app()->language}), array('view', 'id'=>$data->id, '#'=>'blog')); ?></h3>

    <div class="by-line">
        <?php echo CHtml::link(CHtml::encode($data->author), array('/wow/search', 'f'=>'article', 'a' =>CHtml::encode($data->author))); ?>
        <span class="spacer">//</span> <?php echo date('F j, Y',$data->postdate); ?>
        <?php echo CHtml::link(CHtml::encode($data->commentCount), array('view', 'id'=>$data->id, '#'=>'comments')); ?>
     </div>

     <div class="article-left" style="background-image: url('http://eu.media3.battle.net/cms/blog_thumbnail/<?php echo CHtml::encode($data->image); ?>');">
        <?php echo CHtml::link('<img src="http://eu.battle.net/wow/static/images/homepage/thumb-frame.gif" alt="" />', array('view', 'id'=>$data->id, '#'=>'blog')); ?>
     </div>

     <div class="article-right">
        <div class="article-summary">
            <?php echo CHtml::encode($data->{'desc_'.Yii::app()->language}); ?>
            <?php echo CHtml::link('Далее', array('view', 'id'=>$data->id, '#'=>'blog')); ?>
        </div>
    </div>
    <span class="clear"><!-- --></span>

</div>