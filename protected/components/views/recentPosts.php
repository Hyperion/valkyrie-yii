<ul>
	<?php foreach($this->getRecentPosts() as $post): ?>
	<li><b>
	   <?php echo CHtml::link(CHtml::encode($post->title),
	       array('/post/view', 'id' => $post->id)); ?>
	</b>
	<br />
	<i><?=CHtml::encode($post->category->title)?></i>
	</li>
	<?php endforeach; ?>
</ul>