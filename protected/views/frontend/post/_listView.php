<div class="post">
	<div class="title">
		<?=CHtml::link(CHtml::encode($data['title']), array('/post/view', 'id' => $data['id']))?>
	</div>
	<div class="nav">
		<?=$data['category']?>
	</div>
</div>
