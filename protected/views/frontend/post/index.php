<?php if(!empty($_GET['tag'])): ?>
<h1>Materials Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?=CHtml::link('New',         array('/post/index', 'type' => 'new'))?> 
<?=CHtml::link('Popular',     array('/post/index', 'type' => 'popular'))?> 
<?=CHtml::link('Not Popular', array('/post/index', 'type' => 'notpopular'))?> 
<?=CHtml::link('Editable',    array('/post/index', 'type' => 'editable'))?>
<table>
<tr>
<?php if($type): ?>
<td>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_listView',
    'template'=>"{items}\n{pager}",
)); ?>
</td>
<?php
else: 
	foreach($dataProvider as $type => $provider):
?>
<td>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$provider,
	'itemView'=>'_listView',
	'template'=>"{items}\n{pager}",
)); ?>
</td>
<?php 
	endforeach;
endif;
?>
</tr>
</table>
