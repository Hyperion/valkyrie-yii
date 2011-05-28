<div class="item-detail">
    <span  class="icon-frame frame-56" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/<?=$model->icon?>.jpg");'></span>
    <h3 class="subheader color-q<?=$model->Quality?>"><?=$model->name?></h3>
    <ul class="item-specs" style="margin: 0">
        <?php if($model->map_text): ?>
		<li><?=$this->map_text?></li>
		<?php endif; if($model->Flags & $model::ITEM_FLAGS_CONJURED): ?>
		<li>Conjured</li>
		<?php endif; if($model->bonding > 0 && $model->bonding < 4): ?>
		<li><?=$model::itemAlias('bonding',$model->bonding)?></li>
		<?php endif; if($model->maxcount == 1): ?>
		<li>Unique</li>
		<?php endif; if(in_array($model->class, array($model::ITEM_CLASS_ARMOR, $model::ITEM_CLASS_WEAPON))): ?>
        <li><span class="float-right"><?=$model->subclass_text?></span><?=$model::itemAlias('invtype', $model->InventoryType)?></li>
        <?php endif; if($model->class == $model::ITEM_CLASS_CONTAINER): ?>
		<li><?=$model->ContainerSlots?> Slot Bag</li>
		<?php endif; if($model->class == $model::ITEM_CLASS_WEAPON): ?>
        <li>
			<span class="float-right">Speed <?=$model->delay/1000?></span>
			<?=$model->dmg_min1?> - <?=$model->dmg_max1?> Damage
		</li>
		<li>(<?=$model->dps?>  damage per second)</li>
        <?php endif; if($model->class == $model::ITEM_CLASS_PROJECTILE && $model->dmg_min1 > 0 && $model->dmg_max1 > 0): ?>
        <li>+<?=($model->dmg_min1 + $model->dmg_max1) / 2?> damage per second</li>
		<?php endif; if($model->block > 0): ?>
		<li><?=$model->block?> Block</li>
		<?php endif; if($model->fire_res > 0): ?>
		<li>+<?=$model->fire_res?> Fire Resistance</li>
        <?php endif; if($model->nature_res > 0): ?>
		<li>+<?=$model->nature_res?> Nature Resistance</li>
        <?php endif; if($model->frost_res > 0): ?>
		<li>+<?=$model->frost_res?> Frost Resistance</li>
        <?php endif; if($model->shadow_res > 0): ?>
		<li>+<?=$model->shadow_res?> Shadow Resistance</li>
        <?php endif; if($model->arcane_res > 0): ?>
		<li>+<?=$model->arcane_res?> Arcane Resistance</li>
        <?php endif; if($model->armor > 0): ?>
		<li><?=$model->armor?> Armor</li>
		<?php endif; foreach($model->ItemStat as $stat):
            if($stat['type'] >= 3 && $stat['type'] <= 8): ?>
		<li id="stat-<?=$stat['type']?>">+<span><?=$stat['value']?></span> <?=$model::itemAlias('stat', $stat['type'])?></li>
		<?php endif; endforeach; if($model->MaxDurability > 0): ?>
        <li>Durability <?=$model->MaxDurability?>/<?=$model->MaxDurability?></li>
		<?php endif; if(is_array($model->classes)): ?>
        <li>Classes: <?=implode(', ', $model->classes)?></li>
        <?php endif; if(is_array($model->races)): ?>
        <li>Races: <?=implode(', ', $model->races)?></li>
        <?php endif; if($model->RequiredLevel > 0): ?>
		<li>Requires Level <?=$model->RequiredLevel?></li>
		<?php endif; if($model->skill): ?>
        <li>Requires <?=$model->skill?> (<?=$model->RequiredSkillRank?>)</li>
        <?php endif; if($model->spell): ?>
        <li>Requires <?=$model->spell?></li>
        <?php endif; if($model->faction) :?>
		<li>Requires <?$model->faction?> - <?=Faction::itemAlias('rank',$model->RequiredReputationRank)?></li>
        <?php endif; if($model->ItemLevel > 0): ?>
        <li>Item Level <?=$model->ItemLevel?></li>
        <?php endif; if($model->itemset > 0): ?>
		<li>
        	<ul class="item-specs">
            	<li class="color-tooltip-yellow"><?=$model->item_set['name']?> (0/<?=$model->item_set['count']?>)</li>
        <?php foreach($model->item_set['items'] as $item): ?>
				<li class="indent">
					<a class="color-d4 has-tip" href="/wow/item/<?=$item['entry']?>"><?=$item['name']?></a>
				</li>
		<?php endforeach; ?>
            	<li class="indent-top"></li>
        <?php foreach($model->item_set['bonuses'] as $piece => $spell): ?>
				<li class="color-d4">(<?=$piece?>) <?=$spell->info?></li>
		<?php endforeach; ?>
        	</ul>
        </li>
        <?php endif; for($i = 0; $i < 5; $i++)
            if($model->Spells[$i]['spellid'] > 0) :
                $spell = Spell::model()->findByPk($model->Spells[$i]['spellid']);
                $spell->formatInfo();
                if($spell->info): ?>
        <li class="color-q2"><?=$model::itemAlias('spell_trigger', $model->Spells[$i]['trigger'])?>: <?=$spell->info?></li>
                <?php endif;
				unset($spell);
        	endif; 
		if($model->description): ?>
		<li class="color-tooltip-yellow">"<?=$model->description?>"</li>
		<?php endif; if($model->SellPrice > 0): $sMoney = array('gold', 'silver', 'copper'); ?>
		<li>Sell Price:
        <?php foreach($sMoney as $money): if($model->sell_price[$money] > 0): ?>
        	<span class="icon-<?=$money?>"><?=$model->sell_price[$money]?></span>
        <?php endif; endforeach; ?>
		</li>
        <?php endif; ?>
        //TODO: Item source
    </ul>
<span class="clear"><!-- --></span>
</div>