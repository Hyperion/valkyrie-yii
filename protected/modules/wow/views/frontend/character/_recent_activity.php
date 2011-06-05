<div class="profile-recentactivity">
<h3 class="category ">Последние новости</h3>
<div class="profile-box-simple">
<ul class="activity-feed">
<?php
if(count($model->feed))
	foreach($model->feed as $event)
	    switch($event['type']) {
    	    case 2: ?>
	<li><dl>
	<dd><a href="/wow/item/<?=$event['data']?>" class="color-q<?=$event['item']->Quality?>" data-item="">
       	<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/<?=$event['item']->icon?>.jpg");'></span></a>
        Получено <a href="/wow/item/<?=$event['data']?>" class="color-q<?=$event['item']->Quality?>" data-item=""><?=$event['item']->name?></a>
    </dd>
	<dt><?=date('d/m/Y', $event['date'])?></dt>
	</dl></li>
<?php break;
			case 3:
                   // echo sprintf('<li class="bosskill"><dl><dd><span class="icon"></span>%s: %d</dd><dt>%s</dt></dl></li>', $event['name'], $event['count'], $event['date']);
                    break;
            } ?>
</ul>
<a class="profile-linktomore" rel="np" href="/wow/character/feed/<?=Database::$realm?>/<?=$model->name?>">Смотреть более ранние новости</a>
<span class="clear"><!-- --></span>
</div>
</div>
