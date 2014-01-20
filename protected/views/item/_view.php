<span  class="icon-frame frame-56" style='background-image: url("http://media.blizzard.com/wow/icons/56/<?php echo $model->icon; ?>.jpg");'>
    <?php if($model->stackable > 1): ?>
        <span class="stack"><?php echo $model->stackable; ?></span>
    <?php endif; ?>
</span>
<?php if($this->isAjax): ?>
<h3 class="color-q<?php echo $model->Quality ?>"><?php echo $model->name; ?></h3>
<?php endif; ?>
<ul class="item-specs" style="margin: 0">
    <?php if($model->Map): ?>
        <li><?php echo $this->map_text ?></li>
    <?php endif;
    if($model->Flags & $model::ITEM_FLAGS_CONJURED):
        ?>
        <li>Conjured</li>
    <?php endif;
    if($model->bonding > 0 && $model->bonding < 4):
        ?>
        <li><?php echo $model::itemAlias('bonding', $model->bonding) ?></li>
    <?php endif;
    if($model->maxcount == 1):
        ?>
        <li>Unique</li>
    <?php endif;
    if(in_array($model->class, array($model::ITEM_CLASS_ARMOR, $model::ITEM_CLASS_WEAPON))):
        ?>
        <li><span class="float-right"><?php echo $model->subclass_text ?></span><?php echo $model::itemAlias('invtype', $model->InventoryType) ?></li>
    <?php endif;
    if($model->class == $model::ITEM_CLASS_CONTAINER):
        ?>
        <li><?php echo $model->ContainerSlots ?> Slot Bag</li>
<?php endif;
if($model->class == $model::ITEM_CLASS_WEAPON && $model->delay):
    ?>
        <li>
            <span>Speed <?php echo $model->delay / 1000 ?></span>
        <?php echo $model->dmg_min1 ?> - <?php echo $model->dmg_max1 ?> Damage
        </li>
        <li>(<?php echo $model->dps ?>  damage per second)</li>
    <?php endif;
    if($model->class == $model::ITEM_CLASS_PROJECTILE && $model->dmg_min1 > 0 && $model->dmg_max1 > 0):
        ?>
        <li>+<?php echo ($model->dmg_min1 + $model->dmg_max1) / 2 ?> damage per second</li>
    <?php endif;
    if($model->block):
        ?>
        <li><?php echo $model->block ?> Block</li>
    <?php endif;
    if($model->armor):
        ?>
        <li><?php echo $model->armor ?> Armor</li>
    <?php endif;
    if($model->fire_res):
        ?>
        <li>+<?php echo $model->fire_res ?> Fire Resistance</li>
    <?php endif;
    if($model->nature_res):
        ?>
        <li>+<?php echo $model->nature_res ?> Nature Resistance</li>
    <?php endif;
    if($model->frost_res):
        ?>
        <li>+<?php echo $model->frost_res ?> Frost Resistance</li>
    <?php endif;
    if($model->shadow_res):
        ?>
        <li>+<?php echo $model->shadow_res ?> Shadow Resistance</li>
    <?php endif;
    if($model->arcane_res):
        ?>
        <li>+<?php echo $model->arcane_res ?> Arcane Resistance</li>
    <?php
    endif;
    foreach($model->stats as $stat):
        if($stat['type'] >= 3 && $stat['type'] <= 8):
            ?>
            <li id="stat-<?php echo $stat['type'] ?>">+<span><?php echo $stat['value'] ?></span> <?php echo $model::itemAlias('stat', $stat['type']) ?></li>
        <?php
        endif;
    endforeach;
    if(isset($data['enchant_id']) && $data['enchant_id'] > 0):
        ?>
        <li class="color-tooltip-green"><?php echo $model->getEnchantText((int) $data['enchant_id']) ?></li>
    <?php endif;
    if($model->MaxDurability > 0):
        ?>
        <li>Durability <?php echo $model->MaxDurability ?>/<?php echo $model->MaxDurability ?></li>
    <?php endif;
    if($model->AllowableClass AND is_array($model->required_classes)):
        ?>
        <li>Classes: <?php echo implode(', ', $model->required_classes) ?></li>
    <?php endif;
    if($model->AllowableRace AND is_array($model->required_races)):
        ?>
        <li>Races: <?php echo implode(', ', $model->required_races) ?></li>
<?php endif;
if($model->RequiredLevel):
    ?>
        <li>Requires Level <?php echo $model->RequiredLevel ?></li>
    <?php endif;
    if($model->RequiredSkill):
        ?>
        <li>Requires <?php echo $model->required_skill ?> (<?php echo $model->RequiredSkillRank ?>)</li>
    <?php endif;
    if($model->requiredspell):
        ?>
        <li>Requires <?php echo $model->required_spell ?></li>
        <?php endif;
        if($model->RequiredReputationFaction) :
            ?>
        <li>Requires <?php echo $model->required_faction ?> - <?php echo CharacterReputation::itemAlias('rank', $model->RequiredReputationRank) ?></li>
    <?php endif;
    if($model->ItemLevel):
        ?>
        <li>Item Level <?php echo $model->ItemLevel ?></li>
    <?php endif;
    foreach($model->spells as $spell):
        ?>
        <li class="color-q2">
            <a href="<?php echo Yii::app()->request->baseUrl ?>/spell/<?php echo $spell['spellid'] ?>">
        <?php echo $model::itemAlias('spell_trigger', $spell['trigger']) ?>: <?php echo $spell['description'] ?>
            </a>
        </li>
    <?php endforeach;
    if($model->description):
        ?>
        <li class="color-tooltip-yellow">"<?php echo $model->description ?>"</li>
                <?php
            endif;
            if($model->SellPrice > 0):
                $sMoney = array('gold', 'silver', 'copper');
                $price = $model->getPrice($model->SellPrice);
                ?>
        <li>Sell Price:
                <?php foreach($sMoney as $money): if($price[$money] > 0): ?>
                    <span class="icon-<?php echo $money ?>"><?php echo $price[$money] ?></span>
        <?php endif;
    endforeach;
    ?>
        </li>
    <?php
endif;
if($model->itemset):
    if(isset($data['set'])):
        $equipped    = explode(',', $data['set']);
        $count       = count($equipped);
    else:
        $equipped = array();
        $count    = 0;
    endif;
    ?>
        <li>
            <ul class="item-specs">
                <li class="color-tooltip-yellow"><?php echo $model->set['name'] ?> (<?php echo $count ?>/<?php echo $model->set['count'] ?>)</li>
    <?php foreach($model->set['items'] as $item): ?>
                    <li class="indent">
                        <a class="color-<?php echo ((in_array($item['entry'], $equipped)) ? 'tooltip-beige' : 'd4') ?>" href="<?php echo Yii::app()->request->baseUrl ?>/item/<?php echo $item['entry'] ?>"><?php echo $item['name'] ?></a>
                    </li>
    <?php endforeach; ?>
                <li class="indent-top"></li>
    <?php foreach($model->set['bonuses'] as $piece => $spell): ?>
                    <li class="color-<?php echo (($piece <= $count) ? 'tooltip-green' : 'd4') ?>">(<?php echo $piece ?>) Set: <a href="<?php Yii::app()->request->baseUrl ?>/spell/<?php echo $spell->spellID ?>"><?php echo $spell->info ?></a></li>
    <?php endforeach; ?>
            </ul>
        </li>
<?php endif; ?>
</ul>
