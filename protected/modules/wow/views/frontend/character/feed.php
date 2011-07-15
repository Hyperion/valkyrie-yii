<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm.' @ '.$model->name => array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']),
    'Лента новостей' => array('/wow/character/feed', 'realm' => Database::$realm, 'name' => $model['name']),
); ?>
<div class="profile-sidebar-anchor">
    <div class="profile-sidebar-outer">
        <div class="profile-sidebar-inner">
            <div class="profile-sidebar-contents">

        <div class="profile-sidebar-crest">
            <?=CHtml::link('<span class="hover"></span><span class="fade"></span>',
                array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']),
                array(
                    'rel' => 'np',
                    'class' => 'profile-sidebar-character-model',
                    'style' => "background-image: url(/images/wow/2d/inset/{$model['race']}-{$model['gender']}.jpg);",
            ))?>
            <div class="profile-sidebar-info">
                <div class="name">
                    <?=CHtml::link($model['name'], array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?>
                </div>

                <div class="under-name color-c<?=$model['class']?>">
                    <a href="/wow/game/race/<?=$model['race']?>" class="race"><?=$model['race_text']?></a> -
                    <a href="/wow/game/class/<?=$model['class']?>" class="class"><?=$model['class_text']?></a>
                    <span class="level"><strong><?=$model['level']?></strong></span> lvl<span class="comma">,</span>
                </div>

                <div class="realm">
                    <span id="profile-info-realm" class="tip" data-battlegroup="<?=CHtml::encode(Database::$realm)?>"><?=CHtml::encode(Database::$realm)?></span>
                </div>


            </div>
        </div>

<?php $this->widget('WProfileSidebarMenu', array(
    'items' => array(
        array(
            'label'=>'Сводка',
            'url'=>array('/wow/character/simple', 'realm'=>Database::$realm, 'name'=>$model->name)
        ),
        array(
            'label'=>'Таланты',
            'url'=>array('/wow/character/talents', 'realm'=>Database::$realm, 'name'=>$model->name)
        ),
        array(
            'label'=>'Репутация',
            'url'=>array('/wow/character/reputation', 'realm'=>Database::$realm, 'name'=>$model->name)
        ),
        array(
            'label'=>'PvP',
            'url'=>array('/wow/character/pvp', 'realm'=>Database::$realm, 'name'=>$model->name)
        ),
        array(
            'label'=>'Лента новостей',
            'url'=>array('/wow/character/feed', 'realm'=>Database::$realm, 'name'=>$model->name)
        ),
    ),
)); ?>
            </div>
        </div>
    </div>
</div>
<div class="profile-contents">
    <div class="profile-section-header">
        <h3 class="category ">Лента новостей</h3>
    </div>

    <div class="profile-section">
    <ul class="activity-feed activity-feed-wide">
<?php
$i=0;
foreach($model->getFeed(50) as $event):
    switch($event['type'])
    {
        case 2:
?>
    <li><dl>
    <dd><a href="/wow/item/<?=$event['data']?>" class="color-q<?=$event['item']->Quality?>" data-item="">
        <span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/<?=$event['item']->icon?>.jpg");'></span></a>
        Получено <a href="/wow/item/<?=$event['data']?>" class="color-q<?=$event['item']->Quality?>" data-item=""><?=$event['item']->name?></a>
    </dd>
    <dt><?=date('d/m/Y', $event['date'])?></dt>
    </dl></li>
<?php
        break;
        case 3:
?>
    <li class="bosskill"><dl>
    <dd><span class="icon"></span><?=$event['count']?> <?=CHtml::link($event['data']->name, array('/wow/creature/view', 'id' => $event['data']->entry))?> <?=($event['count'] > 1) ? 'убийств' : 'убийство'?></dd>
    <dt><?=date('d/m/Y', $event['date'])?></dt>
    </dl></li>
<?php
        break;
    }
    $i++;
endforeach;
?>
    </ul>
    <div class="activity-note">Отображаются <?=$i?> последних событий, связанных с персонажем.</div>
    </div>
</div>
