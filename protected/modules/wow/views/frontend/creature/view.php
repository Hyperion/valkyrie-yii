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
    $tabs["Добыча (".$model->loot->totalItemCount.")"] = array('ajax'=>'/wow/creature/loot/id/'.$model->entry);
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=> $tabs,
    'cssFile' => false,
    'headerTemplate' => '<li><a href="{url}" data-key="{id}" id="tab-{id}"><span><span>{title}</span></span></a></li>',
));
?>
</div>

