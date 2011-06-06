<div id="summary-stats-simple" class="summary-stats-simple">
	<div class="summary-stats-simple-base">
<?php

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Base',
	'items' => array(
		array(
			'label' => 'Strength',
			'value' => $model->strength,
			'itemOptions' => array('data-id' => 'strength'),
			'htmlOptions' => 
				($model->strength > $model->levelStats['strength'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Agility',
			'value' => $model->agility,
			'itemOptions' => array('data-id' => 'agility'),
			'htmlOptions' => 
				($model->agility > $model->levelStats['agility'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Stamina',
			'value' => $model->stamina,
			'itemOptions' => array('data-id' => 'stamina'),
			'htmlOptions' => 
				($model->stamina > $model->levelStats['stamina'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Intellect',
			'value' => $model->intellect,
			'itemOptions' => array('data-id' => 'intellect'),
			'htmlOptions' => 
				($model->intellect > $model->levelStats['intellect'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Spirit',
			'value' => $model->spirit,
			'itemOptions' => array('data-id' => 'spirit'),
			'htmlOptions' => 
				($model->spirit > $model->levelStats['spirit'])
				? array('class' => ' color-q2')
				: array(),
		),
	),
));
?>
	</div>
	<div class="summary-stats-simple-other">
	<a id="summary-stats-simple-arrow" class="summary-stats-simple-arrow" href="javascript:;"></a>

<?php

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Melee',
	'visible' => ($model->character->role == Character::ROLE_MELEE),
	'items' => array(
		array(
			'label' => 'Damage',
			'value' => $model->mainMinDmg.' - '.$model->mainMaxDmg,
			'itemOptions' => array('data-id' => 'meleedamage'),
		),
		array(
			'label' => 'DPS',
			'value' => ($model->character->isOffhandWeapon()) ? $model->mainDps.'/'.$model->offDps : $model->mainDps,
			'itemOptions' => array('data-id' => 'meleedps'),
		),
		array(
			'label' => 'Attack Power',
			'value' => $model->attackPower+$model->attackPowerMod,
			'itemOptions' => array('data-id' => 'meleeattackpower'),
			'htmlOptions' => ($model->attackPowerMod > 0) ? array('class' => ' color-q2') : array(),

		),
		array(
			'label' => 'Attack Speed',
			'value' => ($model->character->isOffhandWeapon()) ? round($model->mainAttSpeed, 2).'/'.round($model->offAttSpeed, 2) : round($model->mainAttSpeed, 2),
			'itemOptions' => array('data-id' => 'meleespeed'),
		),
		array(
			'label' => 'Crit',
			'value' => round($model->critPct,2).'%',
			'itemOptions' => array('data-id' => 'meleecrit'),
		),
	),
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Ranged',
	'visible' => ($model->character->role == Character::ROLE_RANGED),
	'items' => array(
		array(
			'label' => 'Damage',
			'value' => ($model->character->isRangedWeapon()) ? $model->rangeMinDmg.' - '.$model->rangeMaxDmg : '--',
			'itemOptions' => array('data-id' => 'rangeddamage'),
		),
		array(
			'label' => 'DPS',
			'value' => ($model->character->isRangedWeapon()) ? $model->rangedDps : '--',
			'itemOptions' => array('data-id' => 'rangeddps'),
		),
		array(
			'label' => 'Attack Power',
			'value' => $model->rangedAttackPower+$model->rangedAttackPowerMod,
			'itemOptions' => array('data-id' => 'rangedattackpower'),
            'htmlOptions' => ($model->rangedAttackPowerMod > 0) ? array('class' => ' color-q2') : array(),
		),
		array(
			'label' => 'Attack Speed',
			'value' => ($model->character->isRangedWeapon()) ? $model->rangeAttSpeed : '--',
			'itemOptions' => array('data-id' => 'rangedspeed'),
		),
		array(
			'label' => 'Crit',
			'value' => round($model->rangedCritPct,2).'%',
			'itemOptions' => array('data-id' => 'rangedcrit'),
		),
	),
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Spell',
	'visible' => ($model->character->role == Character::ROLE_CASTER OR $model->character->role == Character::ROLE_HEALER),
	'items' => array(
		array(
			'label' => 'Crit',
			'value' => ($model->character->powerType == Character::POWER_MANA)
				? round(max($model->spellCritPctHoly, $model->spellCritPctFire, $model->spellCritPctNature, $model->spellCritPctFrost, $model->spellCritPctShadow, $model->spellCritPctArcane), 2).'%'
				: '--',
			'itemOptions' => array('data-id' => 'spellcrit'),
		),
	), 
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Defence',
	'visible' => ($model->character->role == Character::ROLE_TANK), 
	'items' => array(
		array(
			'label' => 'Armor',
			'value' => $model->armor,
			'itemOptions' => array('data-id' => 'armor'),
		),
		array(
			'label' => 'Dodge',
			'value' => $model->dodgePct.'%',
			'itemOptions' => array('data-id' => 'dodge'),
		),
		array(
			'label' => 'Parry',
			'value' => $model->parryPct.'%',
			'itemOptions' => array('data-id' => 'parry'),
		),
		array(
			'label' => 'Block',
			'value' => $model->blockPct.'%',
			'itemOptions' => array('data-id' => 'block'),
		),
	),
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Resistance',
	'visible' => false,
	'items' => array(
		array(
			'label' => 'Arcane',
			'value' => $model->resArcane,
			'itemOptions' => array('data-id' => 'arcaneres', 'class' => 'has-icon'),
			'icon' => 'resist_arcane',
		),
		array(
			'label' => 'Fire',
			'value' => $model->resFire,
			'itemOptions' => array('data-id' => 'fireres', 'class' => 'has-icon'),
			'icon' => 'resist_fire',
		),
		array(
			'label' => 'Frost',
			'value' => $model->resFrost,
			'itemOptions' => array('data-id' => 'frostres', 'class' => 'has-icon'),
			'icon' => 'resist_frost',
		),
		array(
			'label' => 'Nature',
			'value' => $model->resNature,
			'itemOptions' => array('data-id' => 'natureres', 'class' => 'has-icon'),
			'icon' => 'resist_nature',
		),
		array(
			'label' => 'Shadow',
			'value' => $model->resShadow,
			'itemOptions' => array('data-id' => 'shadowres', 'class' => 'has-icon'),
			'icon' => 'resist_shadow',
		),
	),
));
?>
	</div>
	<div class="summary-stats-end"></div>
</div>
