<div id="summary-stats-simple" class="summary-stats-simple">
	<div class="summary-stats-simple-base">
<?php

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Base',
	'items' => array(
		array(
			'label' => 'Strength',
			'value' => $model->stats->strength,
			'itemOptions' => array('data-id' => 'strength'),
			'htmlOptions' => 
				($model->stats->strength > $model->stats->levelStats['strength'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Agility',
			'value' => $model->stats->agility,
			'itemOptions' => array('data-id' => 'agility'),
			'htmlOptions' => 
				($model->stats->agility > $model->stats->levelStats['agility'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Stamina',
			'value' => $model->stats->stamina,
			'itemOptions' => array('data-id' => 'stamina'),
			'htmlOptions' => 
				($model->stats->stamina > $model->stats->levelStats['stamina'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Intellect',
			'value' => $model->stats->intellect,
			'itemOptions' => array('data-id' => 'intellect'),
			'htmlOptions' => 
				($model->stats->intellect > $model->stats->levelStats['intellect'])
				? array('class' => ' color-q2')
				: array(),
		),
		array(
			'label' => 'Spirit',
			'value' => $model->stats->spirit,
			'itemOptions' => array('data-id' => 'spirit'),
			'htmlOptions' => 
				($model->stats->spirit > $model->stats->levelStats['spirit'])
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
	'visible' => ($model->role == $model::ROLE_MELEE),
	'items' => array(
		array(
			'label' => 'Damage',
			'value' => $model->stats->mainMinDmg.' - '.$model->stats->mainMaxDmg,
			'itemOptions' => array('data-id' => 'meleedamage'),
		),
		array(
			'label' => 'DPS',
			'value' => ($model->isOffhandWeapon()) ? $model->stats->mainDps.'/'.$model->stats->offDps : $model->stats->mainDps,
			'itemOptions' => array('data-id' => 'meleedps'),
		),
		array(
			'label' => 'Attack Power',
			'value' => $model->stats->attackPower,
			'itemOptions' => array('data-id' => 'meleeattackpower'),
		),
		array(
			'label' => 'Attack Speed',
			'value' => ($model->isOffhandWeapon()) ? round($model->stats->mainAttSpeed, 2).'/'.round($model->stats->offAttSpeed, 2) : round($model->stats->mainAttSpeed, 2),
			'itemOptions' => array('data-id' => 'meleespeed'),
		),
		array(
			'label' => 'Crit',
			'value' => round($model->stats->critPct,2).'%',
			'itemOptions' => array('data-id' => 'meleecrit'),
		),
	),
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Ranged',
	'visible' => ($model->role == $model::ROLE_RANGED),
	'items' => array(
		array(
			'label' => 'Damage',
			'value' => ($model->isRangedWeapon()) ? $model->stats->rangeMinDmg.' - '.$model->stats->rangeMaxDmg : '--',
			'itemOptions' => array('data-id' => 'rangeddamage'),
		),
		array(
			'label' => 'DPS',
			'value' => ($model->isRangedWeapon()) ? $model->stats->rangedDps : '--',
			'itemOptions' => array('data-id' => 'rangeddps'),
		),
		array(
			'label' => 'Attack Power',
			'value' => $model->stats->rangedAttackPower,
			'itemOptions' => array('data-id' => 'rangedattackpower'),
		),
		array(
			'label' => 'Attack Speed',
			'value' => ($model->isRangedWeapon()) ? $model->stats->rangeAttSpeed : '--',
			'itemOptions' => array('data-id' => 'rangedspeed'),
		),
		array(
			'label' => 'Crit',
			'value' => round($model->stats->rangedCritPct,2).'%',
			'itemOptions' => array('data-id' => 'rangedcrit'),
		),
	),
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Spell',
	'visible' => ($model->role == $model::ROLE_CASTER OR $model->role == $model::ROLE_HEALER),
	'items' => array(
		array(
			'label' => 'Crit',
			'value' => ($model->powerType == $model::POWER_MANA) ? round(max($model->stats->spellCritPctHoly, $model->stats->spellCritPctFire, $model->stats->spellCritPctNature, $model->stats->spellCritPctFrost, $model->stats->spellCritPctShadow, $model->stats->spellCritPctArcane), 2).'%' : '--',
			'itemOptions' => array('data-id' => 'spellcrit'),
		),
	), 
));

$this->widget('WSummaryStatsColumn', array(
	'title' => 'Defence',
	'visible' => ($model->role == $model::ROLE_TANK), 
	'items' => array(
		array(
			'label' => 'Armor',
			'value' => $model->stats->armor,
			'itemOptions' => array('data-id' => 'armor'),
		),
		array(
			'label' => 'Dodge',
			'value' => $model->stats->dodgePct.'%',
			'itemOptions' => array('data-id' => 'dodge'),
		),
		array(
			'label' => 'Parry',
			'value' => $model->stats->parryPct.'%',
			'itemOptions' => array('data-id' => 'parry'),
		),
		array(
			'label' => 'Block',
			'value' => $model->stats->blockPct.'%',
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
			'value' => $model->stats->resArcane,
			'itemOptions' => array('data-id' => 'arcaneres', 'class' => 'has-icon'),
			'icon' => 'resist_arcane',
		),
		array(
			'label' => 'Fire',
			'value' => $model->stats->resFire,
			'itemOptions' => array('data-id' => 'fireres', 'class' => 'has-icon'),
			'icon' => 'resist_fire',
		),
		array(
			'label' => 'Frost',
			'value' => $model->stats->resFrost,
			'itemOptions' => array('data-id' => 'frostres', 'class' => 'has-icon'),
			'icon' => 'resist_frost',
		),
		array(
			'label' => 'Nature',
			'value' => $model->stats->resNature,
			'itemOptions' => array('data-id' => 'natureres', 'class' => 'has-icon'),
			'icon' => 'resist_nature',
		),
		array(
			'label' => 'Shadow',
			'value' => $model->stats->resShadow,
			'itemOptions' => array('data-id' => 'shadowres', 'class' => 'has-icon'),
			'icon' => 'resist_shadow',
		),
	),
));
?>
	</div>
	<div class="summary-stats-end"></div>
</div>
