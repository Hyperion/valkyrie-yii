<div id="summary-inventory" class="summary-inventory summary-inventory-simple">
<?php foreach($model->items as $slot => $item):
    if(!isset($item['entry'])) { ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?>" id="slot-<?=$slot?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="javascript:;" class="empty"><span class="frame"></span></a>
        </div>
    </div>
</div>
<?php } else { ?>
<div data-id="<?=($item['slot']-1)?>" data-type="<?=$item['slot']?>" class="slot slot-<?=$item['slot']?> item-quality-<?=$item['quality']?>" id="slot-<?=$slot?>">
	<div class="slot-inner">
    	<div class="slot-contents">
        	<a href="/wow/item/<?=$item['entry']?>" class="item" data-item="<?=$item['data']?>">
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
