<div id="summary-inventory" class="summary-inventory summary-inventory-simple">
<?php
$item_styles = array(
    Character::EQUIPMENT_SLOT_HEAD      => 'left: 0px; top: 0px;',
    Character::EQUIPMENT_SLOT_NECK      => 'left: 0px; top: 58px;',
    Character::EQUIPMENT_SLOT_SHOULDERS => 'left: 0px; top: 116px;',
    Character::EQUIPMENT_SLOT_BACK      => 'left: 0px; top: 174px;',
    Character::EQUIPMENT_SLOT_CHEST     => 'left: 0px; top: 232px;',
    Character::EQUIPMENT_SLOT_BODY      => 'left: 0px; top: 290px;',
    Character::EQUIPMENT_SLOT_TABARD    => 'left: 0px; top: 348px;',
    Character::EQUIPMENT_SLOT_WRISTS    => 'left: 0px; top: 406px;',
    Character::EQUIPMENT_SLOT_HANDS     => 'top: 0px; right: 0px;',
    Character::EQUIPMENT_SLOT_WAIST     => 'top: 58px; right: 0px;',
    Character::EQUIPMENT_SLOT_LEGS      => 'top: 116px; right: 0px;',
    Character::EQUIPMENT_SLOT_FEET      => 'top: 174px; right: 0px;',
    Character::EQUIPMENT_SLOT_FINGER1   => 'top: 232px; right: 0px;',
    Character::EQUIPMENT_SLOT_FINGER2   => 'top: 290px; right: 0px;',
    Character::EQUIPMENT_SLOT_TRINKET1  => 'top: 348px; right: 0px;',
    Character::EQUIPMENT_SLOT_TRINKET2  => 'top: 406px; right: 0px;',
    Character::EQUIPMENT_SLOT_MAINHAND  => 'left: 241px; bottom: 0px;',
    Character::EQUIPMENT_SLOT_OFFHAND   => 'left: 306px; bottom: 0px;',
    Character::EQUIPMENT_SLOT_RANGED    => 'left: 371px; bottom: 0px;',
);
foreach($item_styles as $slot => $style):
    $item = $model->items[$slot];
    if(!isset($item['entry'])) { ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?>" style="<?=$style?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="javascript:;" class="empty"><span class="frame"></span></a>
        </div>
    </div>
</div>
<?php } else { ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?> item-quality-<?=$item['quality']?>" style="<?=$style?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="/wow/item/<?=$item['entry']?>" class="item" data-item="">
            	<img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?=$item['icon']?>.jpg" alt="" />
                <span class="frame"></span>
            </a>
        </div>
    </div>
</div>
<?php } endforeach; ?>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	new Summary.Inventory({ view: "simple" }, {
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
