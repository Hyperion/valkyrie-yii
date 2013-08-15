<span  class="icon-frame frame-56" style="background-image: url('http://eu.media.blizzard.com/wow/icons/56/<?php echo $model->iconName; ?>.jpg');"></span>
<?php if($this->action->id == 'tooltip'): ?>
<h3><?php echo $model->spellname_loc0; ?></h3>
<?php endif; if($model->manacost): ?>
<div>
    <span><?php echo $model->manacost; ?> mana</span>
<?php if($model->range): ?>
    <span><?php echo $model->range; ?> yd range</span>
<?php endif; ?>
</div>
<?php elseif($model->range): ?>
<div>
    <span><?php echo $model->range; ?> yd range</span>
</div>
<?php endif; ?>
<div>
<?php if($model->castTime): ?>
    <span><?php echo $model->castTime; ?> sec cast</span>
<?php elseif($model->ChannelInterruptFlags): ?>
    <span>Channeled</span>
<?php else: ?>
    <span>Instant</span>
<?php endif; ?>
</div>
<div class="color-tooltip-yellow"><?php echo $model->info; ?></div>
