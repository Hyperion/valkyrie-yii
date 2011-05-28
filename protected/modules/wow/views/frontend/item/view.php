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
		<?php endif;
        /*
        if($model->AllowableClass > 0) {
            $classes_data = WoW_Items::AllowableClasses($model->AllowableClass);
            if(is_array($classes_data)) {
                // Do not check this variable as if(!$classes_data), because WoW_Items::AllowableClasses() returns TRUE if item can be equipped by all of the classes.
                $classes_text = '<li>' . WoW_Locale::GetString('template_item_allowable_classes');
                $prev = false;
                foreach($classes_data as $class_id => $class) {
                    $class_name = WoW_Locale::GetString('character_class_' . $class_id);
                    $t = explode(':', $class_name);
                    if(isset($t[1])) {
                        $class_name = $t[0];
                    }
                    if($prev) {
                        $classes_text .= ', ';
                    }
                    $classes_text .= sprintf(' <a href="/wow/ru/game/class/%s" class="color-c%d">%s</a>', $class['key'], $class_id, $class_name);
                    $prev = true;
                }
                $classes_text .= '</li>';
                echo $classes_text;
            }
        }
        if($model->AllowableRace > 0) {
            $races_data = WoW_Items::AllowableRaces($model->AllowableRace);
            if(is_array($races_data)) {
                // Do not check this variable as if(!$races_data), because WoW_Items::AllowableRaces() returns TRUE if item can be equipped by all of the races.
                $races_text = '<li>' . WoW_Locale::GetString('template_item_allowable_races');
                $prev = false;
                foreach($races_data as $race_id => $race) {
                    $race_name = WoW_Locale::GetString('character_race_' . $race_id);
                    $t = explode(':', $race_name);
                    if(isset($t[1])) {
                        $race_name = $t[0];
                    }
                    if($prev) {
                        $races_text .= ', ';
                    }
                    $races_text .= sprintf(' <a href="/wow/ru/game/race/%s">%s</a>', $race['key'], $race_name);
                    $prev = true;
                }
                $races_text .= '</li>';
                echo $races_text;
            }
        }*/
        if($model->RequiredLevel > 0) printf('<li>%s: %d</li>', 'Required level', $model->RequiredLevel);
        /*if($model->RequiredSkill > 0 && $skillName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_skills` WHERE `id`=%d", WoW_Locale::GetLocale(), $model->RequiredSkill)) {
            echo sprintf('<li>%s<li>', sprintf(WoW_Locale::GetString('template_item_required_skill'), $skillName, $model->RequiredSkillRank));
        }
        if($model->requiredspell > 0 && $spellName = DB::WoW()->selectCell("SELECT `SpellName_s` FROM `DBPREFIX_spell` WHERE `id` = %d", WoW_Locale::GetLocale(), $model->requiredspell)) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_required_spell', $spellName)));
        }
        if($model->RequiredReputationFaction > 0 && $factionName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_faction` WHERE `id` = %d", WoW_Locale::GetLocale(), $model->RequiredReputationFaction)) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_required_reputation'), $factionName, WoW_Locale::GetString('reputation_rank_' . $model->RequiredReputationRank)));
        }
        if($model->ItemLevel > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_itemlevel'), $model->ItemLevel));
        }
        // Green stats
        foreach($model->ItemStat as $stat) {
            if($stat['type'] < 12) {
                continue;
            }
            echo sprintf('<li id="stat-%d" class="color-tooltip-green">%s</li>', $stat['type'], sprintf(WoW_Locale::GetString('template_item_stat_' . $stat['type']), $stat['value']));
        }
        if($model->itemset > 0) {
            $isItemSet = false;
            $equippedItemsCount = 0;
            $totalItemsCount = 0;
            $pieces_text = null;
            $itemsetName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", WoW_Locale::GetLocale(), $model->itemset);
            if(WoW_Items::IsMultiplyItemSet($model->itemset)) {
                $setdata = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetdata` WHERE `original` = %d AND (`item1` = %d OR `item2` = %d OR `item3` = %d OR `item4` = %d OR `item5` = %d)", $model->itemset, $model->entry, $model->entry, $model->entry, $model->entry, $model->entry);
                $totalItemsCount = 5;
            }
            else {
                $setdata = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", $model->itemset);
                for($i = 1; $i < 18; $i++) {
                    if($setdata['item' . $i] > 0) {
                        $totalItemsCount++;
                    }
                    else {
                        break;
                    }
                }
            }
            if(isset($_GET['set'])) {
                $set_pieces_str = $_GET['set'];
                $setpieces = explode(',', $set_pieces_str);
                if(isset($setpieces[0])) {
                    $equippedItemsCount = count($setpieces);
                    $isItemSet = true;
                    $pieces_text = null;
                    for($i = 1; $i < $totalItemsCount+1; $i++) {
                        if(in_array($setdata['item' . $i], $setpieces)) {
                            $pieces_text .= sprintf('<li class="indent"><a class="color-tooltip-beige has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                        }
                        else {
                            $pieces_text .= sprintf('<li class="indent"><a class="color-d4 has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                        }
                    }
                }
            }
            else {
                // Load default itemset
                if(is_array($setdata)) {
                    $isItemSet = true;
                    for($i = 1; $i < 6; $i++) {
                        $pieces_text .= sprintf('<li class="indent"><a class="color-d4 has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                    }
                }
            }
            $itemsetbonus = WoW_Items::GetItemSetBonusInfo(DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", $model->itemset));
            $setbonus_text = null;
            if(is_array($itemsetbonus)) {
                foreach($itemsetbonus as $item_bonus) {
                    $setbonus_text .= sprintf('<li class="%s">(%d) %s</li>', $equippedItemsCount >= $item_bonus['threshold'] ? 'color-tooltip-green' : 'color-d4', $item_bonus['threshold'], sprintf(WoW_Locale::GetString('template_item_set_bonus'), $item_bonus['desc']));
                }
            }
            echo sprintf('<li>
                <ul class="item-specs">
                    <li class="color-tooltip-yellow">%s (%d/5)</li>
                    %s
                    <li class="indent-top"> </li>
                    %s
                </ul>
            </li>', $itemsetName, $equippedItemsCount, $pieces_text, $setbonus_text);
        }*/
        for($i = 0; $i < 5; $i++)
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
		<?php endif; /*

        if($model->SellPrice > 0) {
            $sell_price = WoW_Utils::GetMoneyFormat($model->SellPrice);
            echo sprintf('<li>%s', WoW_Locale::GetString('template_item_sell_price'));
            $sMoney = array('gold', 'silver', 'copper');
            foreach($sMoney as $money) {
                if($sell_price[$money] > 0) {
                    echo sprintf('<span class="icon-%s">%d</span>', $money, $sell_price[$money]);
                }
            }
            echo '</li>';
        }*/
        //TODO: Item source
        ?>
    </ul>
<span class="clear"><!-- --></span>
</div>
