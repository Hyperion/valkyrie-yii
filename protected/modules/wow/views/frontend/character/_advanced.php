<div id="summary-inventory" class="summary-inventory summary-inventory-advanced">
<?php    
$item_styles = array(
    $model::EQUIPMENT_SLOT_HEAD      => 'left: 0px; top: 0px;',
    $model::EQUIPMENT_SLOT_NECK      => 'left: 0px; top: 58px;',
    $model::EQUIPMENT_SLOT_SHOULDERS => 'left: 0px; top: 116px;',
    $model::EQUIPMENT_SLOT_BACK      => 'left: 0px; top: 174px;',
    $model::EQUIPMENT_SLOT_CHEST     => 'left: 0px; top: 232px;',
    $model::EQUIPMENT_SLOT_BODY      => 'left: 0px; top: 290px;',
    $model::EQUIPMENT_SLOT_TABARD    => 'left: 0px; top: 348px;',
    $model::EQUIPMENT_SLOT_WRISTS    => 'left: 0px; top: 406px;',
    $model::EQUIPMENT_SLOT_HANDS     => 'top: 0px; right: 0px;',
    $model::EQUIPMENT_SLOT_WAIST     => 'top: 58px; right: 0px;',
    $model::EQUIPMENT_SLOT_LEGS      => 'top: 116px; right: 0px;',
    $model::EQUIPMENT_SLOT_FEET      => 'top: 174px; right: 0px;',
    $model::EQUIPMENT_SLOT_FINGER1   => 'top: 232px; right: 0px;',
    $model::EQUIPMENT_SLOT_FINGER2   => 'top: 290px; right: 0px;',
    $model::EQUIPMENT_SLOT_TRINKET1  => 'top: 348px; right: 0px;',
    $model::EQUIPMENT_SLOT_TRINKET2  => 'top: 406px; right: 0px;',
    $model::EQUIPMENT_SLOT_MAINHAND  => 'left: -6px; bottom: 0px;',
    $model::EQUIPMENT_SLOT_OFFHAND   => 'left: 271px; bottom: 0px;',
    $model::EQUIPMENT_SLOT_RANGED    => 'left: 548px; bottom: 0px;',
);
foreach($item_styles as $slot => $style) :
	$item = $model->items[$slot];
        if(!isset($item['entry'])): ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?>" style="<?=$style?>">
	<div class="slot-inner">
		<div class="slot-contents">
			<a href="javascript:;" class="empty"><span class="frame"></span></a>
		</div>
	</div>
</div>
<?php continue; endif; ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?> <?=(($item['slot'] >= 6 && $item['slot'] <= 15 && $item['slot'] != 9) ? 'slot-align-right' : null)?> item-quality-<?=$item['quality']?>" style="<?=$style?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="/wow/item/<?=$item['entry']?>" class="item" data-item=""><img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?=$item['icon']?>.jpg" alt="" /><span class="frame"></span></a>
            <div class="details">
                <span class="name-shadow"><?=$item['name']?></span>
                <span class="name color-q<?=$item['quality']?>">
                    <?=(($item['slot'] >= 6 && $item['slot'] <= 15 && $item['slot'] != 9 && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
                    <a href="/wow/item/<?=$item['entry']?>" data-item=""><?=$item['name']?></a>
                    <?=((($item['slot'] < 6 || $item['slot'] > 15 || $item['slot'] == 9) && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
                </span>
				<?php if($item['enchant_id']): ?>
                <span class="enchant-shadow"><?=$item['enchant_text']?></span>
                <div class="enchant color-q2">
				<?php if($item['enchant_item']): ?>
					<a href="/wow/item/<?=$item['enchant_item']?>"><?=$item['enchant_text']?></a>
				<?php else: echo $item['enchant_text'];
				endif; ?> 
				</div>
				<?php endif; ?>
                <span class="level"><?=$item['item_level']?></span>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	new Summary.Inventory({ view: "advanced" }, {
<?php
foreach($model->items as $slot => $item):
	if(!isset($item['entry']))
    	continue; ?>  
<?=$slot?>: {
	name: "<?=$item['name']?>",
    quality: <?=$item['quality']?>,
    icon: "<?=$item['icon']?>"
},
<?php endforeach; ?>
	});
});
//]]>
</script>
