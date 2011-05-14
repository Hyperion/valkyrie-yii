<div class="post">
	<div class="title">
		<?=CHtml::link(CHtml::encode($data->title), $data->url)?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<?php if(!empty($data->img)): ?>
	<img src="<?=$data->img?>" />
	<?php endif; ?>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		Category: <?=$data->category->title?>
		<br />
		<?=CHtml::link('Permalink', $data->url)?> |
		<?=CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments')?> |
		Last updated on <?=date('F j, Y',$data->update_time)?>
		<br />
		Rating: <?=$data->rating?>
		<?=CHtml::link("+", array('/post/vote', 'id' => $data->id, 'type' => 'positive'), array('class' => 'vote'))?>
                <?=CHtml::link("-", array('/post/vote', 'id' => $data->id, 'type' => 'negative'), array('class' => 'vote'))?> 		
	</div>
</div>
<script type="text/javascript"> 
/*<![CDATA[*/
$(document).ready(function() {
$('.nav a.vote').click(function() {
	if(!confirm('Вы уверены, что хотите проголосовать?')) return false;
	var a=this;
	var afterVote=function(){};
	$.ajax({
		type:'POST',
		url:$(this).attr('href'),
		success:function(data) {
			afterDelete(a,true,data);
		},
		error:function(XHR) {
			return afterDelete(a,false,XHR);
		}
	});
	return false;
});
});
/*]]>*/
</script> 
