<div class="sidebar">
	<div class="snippet"> 
 		<div class="model" id="model-<?=$model->entry?>"> 
			<div class="viewer" style="background-image: url(http://eu.media.blizzard.com/wow/renders/items/item<?=$model->entry?>.jpg);"></div> 
		</div> 
 
	<script type="text/javascript"> 
	//<![CDATA[
			$(function() {
				Item.model = new ModelRotator("#model-<?=$model->entry?>");
			});
	//]]>
	</script> 
	</div> 
</div> 
<div class="info">
<div class="title"> 
<h2 class="color-q<?=$model->Quality?>"><?=$model->name?></h2> 
</div>
<div class="item-detail">
<?php $this->renderPartial('_tooltip', array('model' => $model, 'full' => false)); ?>
</div>
</div>