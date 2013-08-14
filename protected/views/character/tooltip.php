<div class="character-tooltip">
    <span class="icon-frame frame-56">
        <img src="/images/wow/2d/avatar/<?=$model->race?>-<?=$model->gender?>.jpg" alt="" width="56" height="56" />
        <span class="frame"></span>
    </span>
    <h3><?=$model->name?></h3>
    <div class="color-c<?=$model->class?>">
        <?=$model->race_text?>-<?=$model->class_text?> (<?=$model->talents['name']?>) <?=$model->level?> ур.
    </div>
    <div class="color-tooltip-<?=Character::itemAlias('factions', $this->_model->faction)?>"><?=Database::$realm?></div>
    <span class="clear"><!-- --></span>
    <?php if($model->talents['maxTreeNo'] != -1): ?>
    <span class="character-talents">
        <span class="icon"><span class="icon-frame frame-12 ">
            <img src="http://eu.media.blizzard.com/wow/icons/18/<?=$model->talents['icon']?>.jpg" alt="" width="12" height="12" />
        </span></span>
        <span class="points"><?=$model->talents[0]['count']?><ins>/</ins><?=$model->talents[1]['count']?><ins>/</ins><?=$model->talents[2]['count']?></span>
    <span class="clear"><!-- --></span>
    </span>
    <?php endif; ?>
</div>
