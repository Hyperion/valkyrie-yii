<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Items'=>array('/wow/item'),
);
if(isset($model->class))
    $this->breadcrumbs[$model->class_text] = array("/wow/item?classId={$model->class}");
if(isset($model->subclass))
    $this->breadcrumbs[$model->subclass_text] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}");
if(isset($model->InventoryType) and $model->class == $model::ITEM_CLASS_ARMOR)
    $this->breadcrumbs[$model::itemAlias('invtype', $model->InventoryType)] = array("/wow/item?classId={$model->class}&subClassId={$model->subclass}&invType={$model->InventoryType}");
$this->breadcrumbs[$model->name] = array("/wow/item/{$model->entry}");
?>

<div class="sidebar">
<?php if($model->class == $model::ITEM_CLASS_WEAPON || ($model->class == $model::ITEM_CLASS_ARMOR && !in_array($model->InventoryType, array(2, 11, 12, 28)))): ?>
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
<?php endif; ?>
	<div class="snippet"> 
		<h3>Это интересно!</h3> 
 		<ul class="fact-list">
<?php if($model->class == $model::ITEM_CLASS_WEAPON || ($model->class == $model::ITEM_CLASS_ARMOR && !in_array($model->InventoryType, array(2, 11, 12, 28)))): ?>
			<li>
				<a href="javascript:;" onclick="ModelViewer.show({ type: 3, typeId: <?=$model->entry?>, displayId: <?=$model->displayid?>, slot: <?=$model->InventoryType?>})">Посмотреть в 3d</a>
			</li>
<?php endif; if($model->DisenchantID): ?> 
			<li> 
				<span class="term">Можно распылить</span> 
			</li> 
<?php endif; if($model->stackable > 1): ?>
            <li>
                <span class="term">Можно положить в связку</span>
            </li>
<?php endif; if($model->BuyPrice): 
	$sMoney = array('gold', 'silver', 'copper');
    $price = $model->getPrice($model->BuyPrice); ?>
            <li>
                <span class="term">Цена покупки: </span>
<?php foreach($sMoney as $money): if($price[$money] > 0): ?>
	           <span class="icon-<?=$money?>"><?=$price[$money]?></span>
<?php endif; endforeach; ?>
            </li>
<?php endif; if($model->SellPrice):
    $sMoney = array('gold', 'silver', 'copper');
    $price = $model->getPrice($model->SellPrice); ?>
            <li>
                <span class="term">Цена продажи: </span>
<?php foreach($sMoney as $money): if($price[$money] > 0): ?>
               <span class="icon-<?=$money?>"><?=$price[$money]?></span>
<?php endif; endforeach; ?>
            </li>
<?php endif; ?>
 		</ul> 
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
<span class="clear"><!-- --></span>
<div class="related">
<?php

$tabs = array();
if($model->dropCreaturesCount)
	$tabs["Добыча с: ({$model->dropCreaturesCount})"] = 'dropCreatures';
if($model->vendors->totalItemCount)
	$tabs["Продаеться: ({$model->vendors->totalItemCount})"] = 'vendors';
if($model->disenchantItems->totalItemCount)
	$tabs["Можно распылить на: ({$model->disenchantItems->totalItemCount})"] = 'disenchantItems';
if($model->disenchantFrom->totalItemCount)
    $tabs["Можно получить распылением с: ({$model->disenchantFrom->totalItemCount})"] = 'disenchantFrom';
if(count($tabs)): ?>
<div class="tabs">
	<ul id="related-tabs"> 
<?php foreach($tabs as $tab => $key): ?>
	<li><a href="#<?=$key?>" data-key="<?=$key?>" data-id="<?=$model->entry?>" id="tab-<?=$key?>"><span><span><?=$tab?></span></span></a></li>
<?php endforeach; ?> 
	</ul> 
	<span class="clear"><!-- --></span> 
</div> 
<div id="related-content" class="loading"> 
<?php endif; ?>
</div>
