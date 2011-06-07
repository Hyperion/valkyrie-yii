<div class="info">
<div class="title"> 
<h2><?=$model->name?></h2> 
</div>
<div class="item-detail">
</div>
</div>
<span class="clear"><!-- --></span>
<div class="related">
<?php
$tabs = array();
if($model->loot->totalItemCount)
    $tabs["Добыча (".$model->loot->totalItemCount.")"] = 'loot';
if(count($tabs)): ?>
<div class="tabs">
	<ul id="related-tabs"> 
<?php foreach($tabs as $tab => $key): ?>
	<li><a href="#<?=$key?>" data-key="<?=$key?>" data-id="<?=$model->entry?>" id="tab-<?=$key?>"><span><span><?=$tab?></span></span></a></li>
<?php endforeach; ?> 
	</ul> 
	<span class="clear"><!-- --></span> 
</div> 
<div id="related-content" class="loading"> 
<?php endif; ?>
</div>

