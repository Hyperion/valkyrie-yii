<span  class="icon-frame frame-56" style="background-image: url('http://eu.media.blizzard.com/wow/icons/56/<?=$model->iconName?>.jpg');"></span>
<h3><?=$model->spellname_loc0?></h3>
<?php if($model->manacost) { ?>
<div><span class="float-left"><?=$model->manacost?> mana</span>
<?php if ($model->range) { ?>
<span class="float-right"><?=$model->range?> yd range</span>
<?php } ?>
<span class="clear"><!-- --></span></div>
<?php } else { ?>
<?php if ($model->range) { ?>
<div><span class="float-left"><?=$model->range?> yd range</span><span class="clear"><!-- --></span></div>
<?php } ?>
<?php } ?>
<?php if($model->castTime) { ?>
<div><span class="float-left"><?=$model->castTime?> sec cast</span><span class="clear"><!-- --></span></div>
<?php } elseif ($model->ChannelInterruptFlags) { ?>
<div><span class="float-left">Channeled</span><span class="clear"><!-- --></span></div>
<?php } else { ?>
<div><span class="float-left">Instant</span><span class="clear"><!-- --></span></div>
<?php } ?>
<div class="color-tooltip-yellow"><?=$model->info?></div>