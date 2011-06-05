<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Items'=>array('/wow/item'),
);
if(isset($model->class))
    $this->breadcrumbs[$model->class_text] = array("/wow/item?classId={$model->class}");
if(isset($model->subclass))
    $this->breadcrumbs[$model->subclass_text] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}");
if(isset($model->InventoryType))
    $this->breadcrumbs[$model::itemAlias('invtype', $model->InventoryType)] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}&invType={$model->InventoryType}");
$this->breadcrumbs[$model->name] = array("/wow/item/{$model->entry}");
?>

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
<?php $this->renderPartial('_tooltip', array('model' => $model, 'data' => false)); ?>
</div>
</div>
