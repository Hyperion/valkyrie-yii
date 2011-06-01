<div id="summary-inventory" class="summary-inventory summary-inventory-advanced">
<?php foreach($model->items as $slot => $item) :
    if(!isset($item['entry'])): ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot <?=(($item['slot'] >= 6 && $item['slot'] <= 15 && $item['slot'] != 9 || $item['slot'] == 21) ? 'slot-align-right' : null)?> slot-<?=$item['slot']?>" id="slot-<?=$slot?>">
	<div class="slot-inner">
		<div class="slot-contents">
			<a href="javascript:;" class="empty"><span class="frame"></span></a>
		</div>
	</div>
</div>
<?php continue; endif; ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?> <?=(($item['slot'] >= 6 && $item['slot'] <= 14 && $item['slot'] != 9 || $item['slot'] == 21 || $item['slot'] == 17) ? 'slot-align-right' : null)?> item-quality-<?=$item['quality']?>" id="slot-<?=$slot?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="/wow/item/<?=$item['entry']?>" class="item" data-item="<?=$item['data']?>"><img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?=$item['icon']?>.jpg" alt="" /><span class="frame"></span></a>
            <div class="details">
                <span class="name-shadow"><?=$item['name']?></span>
                <span class="name color-q<?=$item['quality']?>">
                    <?=((($item['slot'] >= 6 && $item['slot'] <= 14 && $item['slot'] != 9 || $item['slot'] == 21 || $item['slot'] == 17) && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
                    <a href="/wow/item/<?=$item['entry']?>" data-item="<?=$item['data']?>"><?=$item['name']?></a>
                    <?=(((($item['slot'] < 6 || $item['slot'] > 14 || $item['slot'] == 9) && $item['slot'] != 21 && $item['slot'] != 17) && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
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
