<span  class="icon-frame frame-56" style="background-image: url('http://eu.media.blizzard.com/wow/icons/56/<?=$model->iconName?>.jpg');"></span>
<?php if($this->action->id == 'tooltip'): ?>
<h3><?=$model->spellname_loc0?></h3>
<?php endif; if($model->manacost): ?>
<div>
    <span class="float-left"><?=$model->manacost?> mana</span>
<?php if($model->range): ?>
    <span class="float-right"><?=$model->range?> yd range</span>
<?php endif; ?>
    <span class="clear"><!-- --></span>
</div>
<?php elseif($model->range): ?>
<div>
    <span class="float-left"><?=$model->range?> yd range</span>
    <span class="clear"><!-- --></span>
</div>
<?php endif; ?>
<div>
<?php if($model->castTime): ?>
    <span class="float-left"><?=$model->castTime?> sec cast</span>
<?php elseif($model->ChannelInterruptFlags): ?>
    <span class="float-left">Channeled</span>
<?php else: ?>
    <span class="float-left">Instant</span>
<?php endif; ?>
    <span class="clear"><!-- --></span>
</div>
<div class="color-tooltip-yellow"><?=$model->info?></div>
