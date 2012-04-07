<style>
    /* inventory (shared) */
    .summary-inventory { position: relative}
    .summary-inventory .slot { position: absolute; }
    .summary-inventory a.item { width: 49px; height: 49px; display: block; position: absolute; }
    .summary-inventory a.item img { display: block; width: 44px; height: 44px; padding: 3px 0 0 3px; }
    .summary-inventory a.item:hover .frame { background-color: rgba(255, 255, 255, 0.2); }
    .summary-inventory a.empty { width: 49px; height: 49px; display: block; cursor: help; position: absolute; background: url("/images/wow/character/summary/item-empty-bg.png") no-repeat; opacity: 0.33333; }
    .summary-inventory a.empty:hover { opacity: 0.66666; }
    .summary-inventory a.item .frame, .summary-inventory a.empty .frame { position: absolute; left: 0; top: 0; width: 49px; height: 49px; background: url("/images/wow/icons/frames/inventory-slots.png") no-repeat; }
    .summary-inventory .slot,
    .summary-inventory a.item,
    .summary-inventory a.item .frame,
    .summary-inventory a.empty { -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; }

    /* empty slots */
    .summary-inventory .slot-1  a.empty { background-position: 1px 1px;    } /* Head */
    .summary-inventory .slot-2  a.empty { background-position: 1px -46px;  } /* Neck */
    .summary-inventory .slot-3  a.empty { background-position: 1px -93px;  } /* Shoulder */
    .summary-inventory .slot-16 a.empty,                                     /* Back */
    .summary-inventory .slot-5  a.empty { background-position: 1px -140px; } /* Chest */
    .summary-inventory .slot-19 a.empty { background-position: 1px -187px; } /* Tabard */
    .summary-inventory .slot-4  a.empty { background-position: 1px -234px; } /* Shirt */
    .summary-inventory .slot-9  a.empty { background-position: 1px -281px; } /* Wrist */
    .summary-inventory .slot-10 a.empty { background-position: 1px -328px; } /* Hands */
    .summary-inventory .slot-6  a.empty { background-position: 1px -375px; } /* Waist */
    .summary-inventory .slot-7  a.empty { background-position: 1px -422px; } /* Legs */
    .summary-inventory .slot-8  a.empty { background-position: 1px -469px; } /* Feet */
    .summary-inventory .slot-11 a.empty { background-position: 1px -516px; } /* Finger */
    .summary-inventory .slot-12 a.empty { background-position: 1px -563px; } /* Trinket */
    .summary-inventory .slot-21 a.empty { background-position: 1px -610px; } /* Main Hand */
    .summary-inventory .slot-22 a.empty { background-position: 1px -657px; } /* Off Hand */
    .summary-inventory .slot-15 a.empty { background-position: 1px -704px; } /* Ranged */
    .summary-inventory .slot-28 a.empty { background-position: 1px -751px; } /* Relic */

    .summary-inventory .slot-pos-0  { left: 0px; top: 0px; } /* Head */
    .summary-inventory .slot-pos-1  { left: 0px; top: 58px;  } /* Neck */
    .summary-inventory .slot-pos-2  { left: 0px; top: 116px;  } /* Shoulder */
    .summary-inventory .slot-pos-14 { left: 0px; top: 174px; } /* Back */
    .summary-inventory .slot-pos-4  {  left: 0px; top: 232px; } /* Chest */
    .summary-inventory .slot-pos-18 { left: 0px; top: 348px;} /* Tabard */
    .summary-inventory .slot-pos-3  { left: 0px; top: 290px; } /* Shirt */
    .summary-inventory .slot-pos-8  { left: 0px; top: 406px; } /* Wrist */
    .summary-inventory .slot-pos-9 { top: 0px; right: 0px; } /* Hands */
    .summary-inventory .slot-pos-5  { top: 58px; right: 0px; } /* Waist */
    .summary-inventory .slot-pos-6  { top: 116px; right: 0px; } /* Legs */
    .summary-inventory .slot-pos-7  { top: 174px; right: 0px; } /* Feet */
    .summary-inventory .slot-pos-10 { top: 232px; right: 0px; } /* Finger */
    .summary-inventory .slot-pos-11 { top: 290px; right: 0px; } /* Finger */
    .summary-inventory .slot-pos-12 { top: 348px; right: 0px; } /* Trinket */
    .summary-inventory .slot-pos-13 { top: 406px; right: 0px; } /* Trinket */
    .summary-inventory .slot-pos-15 { left: -6px; bottom: 0px; } /* Main Hand */
    .summary-inventory .slot-pos-16 { left: 271px; bottom: 0px; } /* Off Hand */
    .summary-inventory .slot-pos-17 { left: 548px; bottom: 0px; } /* Relic */

    /* item quality frames */
    .summary-inventory .item-quality-0 a.item .frame { background-position: -49px  0; }
    .summary-inventory .item-quality-1 a.item .frame { background-position: -98px  0; }
    .summary-inventory .item-quality-2 a.item .frame { background-position: -147px 0; }
    .summary-inventory .item-quality-3 a.item .frame { background-position: -196px 0; }
    .summary-inventory .item-quality-4 a.item .frame { background-position: -245px 0; }
    .summary-inventory .item-quality-5 a.item .frame { background-position: -294px 0; }
    .summary-inventory .item-quality-6 a.item .frame { background-position: -343px 0; }
    .summary-inventory .item-quality-7 a.item .frame { background-position: -392px 0; }

    /* inventory (advanced) */
    .summary-inventory-advanced { width: 100%; height: 521px;}
    .summary-inventory-advanced .slot-inner { width: 265px; height: 57px; background: url("/images/wow/character/summary/item-slot-advanced-bg.png") left top repeat-y; }
    .summary-inventory-advanced .slot-highlight .slot-inner { background-position: left bottom; }
    .summary-inventory-advanced .details { position: absolute; width: 204px; height: 49px; left: 57px; top: 4px; white-space: nowrap; }
    .summary-inventory-advanced a.item,
    .summary-inventory-advanced a.empty { position: absolute; left: 4px; top: 4px; }
    .summary-inventory-advanced a.empty { opacity: 0.25; }
    .summary-inventory-advanced .name { position: absolute; font-size: 11px; }
    .summary-inventory-advanced .name { left: 0; top: -2px; }
    .summary-inventory-advanced .audit-warning { display: inline-block; background: url("/images/wow/icons/warning-small.png") right center no-repeat; width: 10px; height: 10px; margin-left: 5px; cursor: help; }
    .summary-inventory-advanced .enchant { position: absolute; font-size: 11px; }
    .summary-inventory-advanced .enchant { left: 0; top: 12px; color: #0f0; }
    .summary-inventory-advanced .enchant .tip { border-bottom: 0; }
    .summary-inventory-advanced .level { position: absolute; left: 0; bottom: -2px; color: #999999; width: 20px; height: 16px; line-height: 16px; font-size: 10px; }

    /* overrides for right-aligned slots */
    .summary-inventory-advanced .slot-align-right .details { left: auto; right: 57px; }
    .summary-inventory-advanced .slot-align-right .slot-inner { background-position: right top; text-align: right; }
    .summary-inventory-advanced .slot-align-right.slot-highlight .slot-inner { background-position: right bottom; }
    .summary-inventory-advanced .slot-align-right a.item,
    .summary-inventory-advanced .slot-align-right a.empty { left: auto; right: 4px; }
    .summary-inventory-advanced .slot-align-right .name,
    .summary-inventory-advanced .slot-align-right .enchant { left: auto; right: 0; }
    .summary-inventory-advanced .slot-align-right .audit-warning { background-position: left center; margin-right: 4px; margin-left: 0; }
    .summary-inventory-advanced .slot-align-right .level { left: auto; right: 0; }

</style>
<div class="summary-inventory summary-inventory-advanced">
    <?php
    foreach($model->items as $slot => $item) :
        if(!isset($item['entry'])):
            ?>
            <div class="slot slot-pos-<?php echo $slot; ?> <?php echo(($slot > 4 && $slot < 16 && $slot != 8 && $slot != 14) ? 'slot-align-right' : null) ?> slot-<?php echo$item ?>">
                <div class="slot-inner">
                    <div class="slot-contents">
                        <a href="javascript:;" class="empty"><span class="frame"></span></a>
                    </div>
                </div>
            </div>
            <?php
            continue;
        endif;
        ?>
        <div class="slot slot-pos-<?php echo $slot; ?> slot-<?php echo $item['slot']; ?><?php echo(($slot > 4 && $slot < 16 && $slot != 8 && $slot != 14) ? ' slot-align-right' : null) ?> item-quality-<?php echo$item['quality'] ?>">
            <div class="slot-inner">
                <div class="slot-contents">
                    <a href="/wow/item/<?php echo$item['entry'] ?>" class="item" data-item="<?php echo$item['data'] ?>"><img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?php echo$item['icon'] ?>.jpg" alt="" /><span class="frame"></span></a>
                    <div class="details">
                        <span class="name color-q<?php echo$item['quality'] ?>">
                            <?php echo((($slot > 4 && $slot < 16 && $slot != 8 && $slot != 14) && !isset($item['enchant_text']) && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null) ?>
                            <a href="/wow/item/<?php echo$item['entry'] ?>" data-item="<?php echo$item['data'] ?>"><?php echo$item['name'] ?></a>
                        <?php echo((($slot < 5 || $slot > 15 || $slot == 8 || $slot == 14) && !isset($item['enchant_text']) && $item['can_enchanted']) ? '<a href="javascript:;" class="audit-warning"></a>' : null) ?>
                        </span>
                            <?php if(isset($item['enchant_text'])): ?>
                            <div class="enchant color-q2">
                                <?php if(isset($item['enchant_item'])): ?>
                                    <a href="/wow/item/<?php echo$item['enchant_item'] ?>"><?php echo$item['enchant_text'] ?></a>
                                    <?php
                                else: echo $item['enchant_text'];
                                endif;
                                ?> 
                            </div>
    <?php endif; ?>
                        <span class="level"><?php echo$item['item_level'] ?></span>
                    </div>
                </div>
            </div>
        </div>
<?php endforeach; ?>
</div>
