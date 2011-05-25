<div class="post">
	<div class="title">
		<?=CHtml::link(CHtml::encode($data->title), $data->url)?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?=CHtml::link('Permalink', $data->url)?> |
		<?=CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments')?> |
		Last updated on <?=date('F j, Y',$data->update_time)?>
	</div>
</div>
