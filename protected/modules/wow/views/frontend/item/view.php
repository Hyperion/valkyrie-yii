<?php
$this->breadcrumbs=array(
    'Game'=>array('/wow'),
    'Items'=>array('/wow/item'),
);
if(isset($model->class_id))
    $this->breadcrumbs[$model->class_text] = array("/wow/item?ItemTemplate[class_id]={$model->class_id}");
if(isset($model->subclass))
    $this->breadcrumbs[$model->subclass_text] = array("/wow/item?ItemTemplate[class_id]={$model->class_id}&ItemTemplate[subclass]={$model->subclass}");
if(isset($model->InventoryType) && $model->class_id == $model::ITEM_CLASS_ARMOR)
    $this->breadcrumbs[$model::itemAlias('invtype', $model->InventoryType)] = array("/wow/item?ItemTemplate[class_id]={$model->class_id}&ItemTemplate[subclass]={$model->subclass}&ItemTemplate[InventoryType]={$model->InventoryType}");
$this->breadcrumbs[] = $model->name;
?>

<div class="sidebar">
	<div class="snippet"> 
		<h3>Это интересно!</h3> 
 		<ul class="fact-list">
<?php if($model->class_id == $model::ITEM_CLASS_WEAPON || ($model->class_id == $model::ITEM_CLASS_ARMOR && !in_array($model->InventoryType, array(2, 11, 12, 28)))): ?>
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
	           <span class="icon-<?php echo $money; ?>"><?php echo $price[$money]; ?></span>
<?php endif; endforeach; ?>
            </li>
<?php endif; if($model->SellPrice):
    $sMoney = array('gold', 'silver', 'copper');
    $price = $model->getPrice($model->SellPrice); ?>
            <li>
                <span class="term">Цена продажи: </span>
<?php foreach($sMoney as $money): if($price[$money] > 0): ?>
               <span class="icon-<?php echo $money; ?>"><?php echo $price[$money]; ?></span>
<?php endif; endforeach; ?>
            </li>
<?php endif; ?>
 		</ul> 
	</div> 
</div> 
<div class="info">
<div class="title"> 
<h2 class="color-q<?php echo $model->Quality; ?>"><?php echo $model->name; ?></h2> 
</div>
<div class="well">
<?php $this->renderPartial('_view', array('model' => $model, 'data' => false)); ?>
</div>
</div>
