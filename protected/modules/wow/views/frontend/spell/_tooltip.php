<span  class="icon-frame frame-56" style="background-image: url('http://eu.media.blizzard.com/wow/icons/56/<?=$model->iconName?>.jpg');"></span>
<h3><?=$model->spellname_loc0?></h3>
<?php if($model->castTime): ?>
<div class="color-q0">Время применения <?=$model->castTime?> сек.<span class="clear"><!-- --></span></div>
<?php endif; ?>
<div class="color-tooltip-yellow"><?=$model->info?></div>
