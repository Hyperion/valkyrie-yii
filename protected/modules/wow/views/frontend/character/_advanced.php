<div id="summary-inventory" class="summary-inventory summary-inventory-advanced">
<?php foreach($model->items as $slot => $item) :
    if(!isset($item['entry'])): ?>
<div data-id="<?php echo($item['slot']-1)?>" data-type="<?php echo$item['slot']?>" class="slot <?php echo(($slot > 4 && $slot < 16 && $slot !=8 && $slot != 14) ? 'slot-align-right' : null)?> slot-<?php echo$item['slot']?>" id="slot-<?php echo$slot?>">
	<div class="slot-inner">
		<div class="slot-contents">
			<a href="javascript:;" class="empty"><span class="frame"></span></a>
		</div>
	</div>
</div>
<?php continue; endif; ?>
<div data-id="<?php echo($item['slot']-1)?>" data-type="<?php echo$item['slot']?>" class="slot slot-<?php echo$item['slot']?> <?php echo(($slot > 4 && $slot < 16 && $slot !=8 && $slot != 14) ? 'slot-align-right' : null)?> item-quality-<?php echo$item['quality']?>" id="slot-<?php echo$slot?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="/wow/item/<?php echo$item['entry']?>" class="item" data-item="<?php echo$item['data']?>"><img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?php echo$item['icon']?>.jpg" alt="" /><span class="frame"></span></a>
            <div class="details">
                <span class="name-shadow"><?php echo$item['name']?></span>
                <span class="name color-q<?php echo$item['quality']?>">
                    <?php echo((($slot > 4 && $slot < 16 && $slot !=8 && $slot != 14) && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
                    <a href="/wow/item/<?php echo$item['entry']?>" data-item="<?php echo$item['data']?>"><?php echo$item['name']?></a>
                    <?php echo((($slot < 5 || $slot > 15 || $slot == 8 || $slot == 14) && !$item['enchant_id'] && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null)?>
                </span>
				<?php if($item['enchant_id']): ?>
                <span class="enchant-shadow"><?php echo$item['enchant_text']?></span>
                <div class="enchant color-q2">
				<?php if($item['enchant_item']): ?>
					<a href="/wow/item/<?php echo$item['enchant_item']?>"><?php echo$item['enchant_text']?></a>
				<?php else: echo $item['enchant_text'];
				endif; ?> 
				</div>
				<?php endif; ?>
                <span class="level"><?php echo$item['item_level']?></span>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
