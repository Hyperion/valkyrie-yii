<style type="text/css"> 
#content .content-top { background: url("/wow/static/images/character/summary/backgrounds/race/<?=$model->race?>.jpg") left top no-repeat; }
.profile-wrapper { background-image: url("/wow/static/images/2d/profilemain/race/<?=$model->race?>-<?=$model->gender?>.jpg"); }
</style>

<div class="profile-sidebar-anchor">
	<div class="profile-sidebar-outer">
		<div class="profile-sidebar-inner">
			<div class="profile-sidebar-contents">

		<div class="profile-info-anchor">
			<div class="profile-info">
				<div class="name"><?=CHtml::link($model['name'], array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?></div>
				<div class="title-guild"></div>
	<span class="clear"><!-- --></span>
				<div class="under-name color-c<?=$model['class']?>">
					<a href="/wow/game/race/<?=$model['race']?>" class="race"><?=$model['race_text']?></a>-<a href="/wow/game/class/<?=$model['class']?>" class="class"><?=$model['class_text']?></a> (<span id="profile-info-spec" class="spec tip">Test</span>) <span class="level"><strong><?=$model['level']?></strong></span> lvl<span class="comma">,</span>
					<span class="realm tip" id="profile-info-realm" data-battlegroup="<?=CHtml::encode(Database::$realm)?>">
						<?=CHtml::encode(Database::$realm)?>
					</span>
				</div>
			</div>
		</div>
		
			</div>
		</div>
	</div>
</div>

<div class="profile-contents">

<div class="summary-top">

<div class="summary-top-right">
	<ul class="profile-view-options" id="profile-view-options-summary">
		<li><a href="javascript:;" rel="np" class="threed disabled">3D</a></li>
		<li><?=CHtml::link('Advanced', array('/wow/character/advanced', 'realm' => Database::$realm, 'name' => $model['name']))?></li>
		<li class="current"><?=CHtml::link('Simple', array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?></li>
	</ul>
	<div class="summary-averageilvl"> 
		<div class="rest"> 
		Средний<br /> 
		(<span class="equipped">364</span> Экипирован)
		</div> 
		<div id="summary-averageilvl-best" class="best tip" data-id="averageilvl">365</div> 
	</div> 
</div>

<div class="summary-top-inventory">
	<div id="summary-inventory" class="summary-inventory summary-inventory-simple">
<?php
    $item_slots = array(
        Character::EQUIPMENT_SLOT_HEAD      => array('slot' => 1,  'style' => ' left: 0px; top: 0px;'),
        Character::EQUIPMENT_SLOT_NECK      => array('slot' => 2,  'style' => ' left: 0px; top: 58px;'),
        Character::EQUIPMENT_SLOT_SHOULDERS => array('slot' => 3,  'style' => 'left: 0px; top: 116px;'),
        Character::EQUIPMENT_SLOT_BACK      => array('slot' => 16, 'style' => ' left: 0px; top: 174px;'),
        Character::EQUIPMENT_SLOT_CHEST     => array('slot' => 5,  'style' => ' left: 0px; top: 232px;'),
        Character::EQUIPMENT_SLOT_BODY      => array('slot' => 4,  'style' => ' left: 0px; top: 290px;'),
        Character::EQUIPMENT_SLOT_TABARD    => array('slot' => 19, 'style' => ' left: 0px; top: 348px;'),
        Character::EQUIPMENT_SLOT_WRISTS    => array('slot' => 9,  'style' => ' left: 0px; top: 406px;'),
        Character::EQUIPMENT_SLOT_HANDS     => array('slot' => 10, 'style' => ' top: 0px; right: 0px;'),
        Character::EQUIPMENT_SLOT_WAIST     => array('slot' => 6,  'style' => ' top: 58px; right: 0px;'),
        Character::EQUIPMENT_SLOT_LEGS      => array('slot' => 7,  'style' => ' top: 116px; right: 0px;'),
        Character::EQUIPMENT_SLOT_FEET      => array('slot' => 8,  'style' => ' top: 174px; right: 0px;'),
        Character::EQUIPMENT_SLOT_FINGER1   => array('slot' => 11, 'style' => ' top: 232px; right: 0px;'),
        Character::EQUIPMENT_SLOT_FINGER2   => array('slot' => 11, 'style' => ' top: 290px; right: 0px;'),
        Character::EQUIPMENT_SLOT_TRINKET1  => array('slot' => 12, 'style' => ' top: 348px; right: 0px;'),
        Character::EQUIPMENT_SLOT_TRINKET2  => array('slot' => 12, 'style' => ' top: 406px; right: 0px;'),
        Character::EQUIPMENT_SLOT_MAINHAND  => array('slot' => 21, 'style' => ' left: 241px; bottom: 0px;'),
        Character::EQUIPMENT_SLOT_OFFHAND   => array('slot' => 22, 'style' => ' left: 306px; bottom: 0px;'),
        Character::EQUIPMENT_SLOT_RANGED    => array('slot' => 28, 'style' => ' left: 371px; bottom: 0px;')
    );
    foreach($item_slots as $slot => $data):
        $item_info = $model->getEquippedItemInfo($slot);
        if(!$item_info || $item_info['item_id'] == 0) { ?>
            <div data-id="<?=($data['slot']-1)?>" data-type="<?=$data['slot']?>" class="slot slot-<?=$data['slot']?>" style="<?=$data['style']?>">
            <div class="slot-inner">
            <div class="slot-contents"><a href="javascript:;" class="empty"><span class="frame"></span></a>
            </div>
            </div>
            </div>
        <?php } else { ?>
            <div data-id="<?=($data['slot']-1)?>" data-type="<?=$data['slot']?>" class="slot slot-<?=$data['slot']?> <?=(($slot >= 9 && $slot <= 15) ? 'slot-align-right' : null)?> item-quality-<?=$item_info['quality']?>" style="<?=$data['style']?>">
            <div class="slot-inner">
            <div class="slot-contents"><a href="/wow/item/<?=$item_info['item_id']?>" class="item" data-item="<?=$item_info['data-item']?>"><img src="http://eu.battle.net/wow-assets/static/images/icons/56/<?=$item_info['icon']?>.jpg" alt="" /><span class="frame"></span></a>
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
            if(isset($item_slots) && is_array($item_slots)) {
                foreach($item_slots as $slot => $style) {
                    $item_info = $model->GetEquippedItemInfo($slot);
                    if(!$item_info) {
                        continue;
                    }
                    echo sprintf('
             %d: {
                    name: "%s",
                    quality: %d,
                    icon: "%s"
                },', $slot, $item_info['name'], $item_info['quality'], $item_info['icon']);
                }
            }
            ?>
			});
		});
	//]]>
	</script>
</div>

</div>

<div class="summary-bottom">
	<div class="summary-bottom-left">
		<div class="summary-health-resource">
			<ul>
			<li class="health" id="summary-health" data-id="health">
				<span class="name">Health</span>
				<span class="value"><?=$model->health?></span>
			</li>
			</ul>
		</div>
		<div class="summary-stats-profs-bgs">
			<div class="summary-stats" id="summary-stats"></div>
		</div>
	</div>
	<span class="clear"><!-- --></span>
</div>