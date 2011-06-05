<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm.' @ '.$model->name => array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']),
); ?>
<div class="profile-sidebar-anchor">
    <div class="profile-sidebar-outer">
        <div class="profile-sidebar-inner">
            <div class="profile-sidebar-contents">
                <div class="profile-info-anchor">
                    <div class="profile-info">
                        <div class="name">
                            <?=CHtml::link($model['name'], array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']))?>
                        </div>
                        <div class="title-guild"></div>
                        <span class="clear"><!-- --></span>
                        <div class="under-name color-c<?=$model['class']?>">
                            <a href="/wow/game/race/<?=$model['race']?>" class="race"><?=$model['race_text']?></a> -
                            <a href="/wow/game/class/<?=$model['class']?>" class="class"><?=$model['class_text']?></a> 
                            (<span id="profile-info-spec" class="spec tip"><?=$model->talentData['name']?></span>) 
                            <span class="level"><strong><?=$model['level']?></strong></span> lvl<span class="comma">,</span>
                            <span class="realm tip" id="profile-info-realm" data-battlegroup="<?=CHtml::encode(Database::$realm)?>"><?=CHtml::encode(Database::$realm)?></span>
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
    ),
)); ?>
            </div>
        </div>
    </div>
</div>
<div class="profile-contents">
    <div class="summary-top">
        <div class="summary-top-right">
<?php $this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'profile-view-options'),
    'id' => 'profile-view-options-summary',
    'activeCssClass' => 'current',
    'items' => array(
        array(
            'label' => '3d',
            'url' => array('/wow/character/threed', 'realm' => Database::$realm, 'name' => $model->name),
            'linkOptions' => array('rel' => 'np', 'class' => 'threed'),
        ),
        array(
            'label' => 'Advanced',
            'url' => array('/wow/character/advanced', 'realm' => Database::$realm, 'name' => $model->name),
            'linkOptions' => array('rel' => 'np', 'class' => 'advanced'),
        ),
        array(
            'label' => 'Simple',
            'url' => array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model->name),
            'linkOptions' => array('rel' => 'np', 'class' => 'simple'),
        ),
    )    
)); ?>
            <div class="summary-averageilvl"> 
                <div class="rest">Средний
                    <br />(<span class="equipped"><?=$model->itemLevel['avg']?></span> Экипирован)
                </div> 
                <div id="summary-averageilvl-best" class="best tip" data-id="averageilvl"><?=$model->itemLevel['avg']?></div>
            </div> 
        </div>
        <div class="summary-top-inventory">
<?php
switch($this->action->id)
{
    case 'threed':
        $this->renderPartial('_3d', array('model' => $model));
        break;
    case 'advanced':
        $this->renderPartial('_advanced', array('model' => $model));
        break;
    default: case 'simple':
        $this->renderPartial('_simple', array('model' => $model));
        break;
}
?>
        </div>
    </div>
    <div class="summary-bottom">
<?php $this->renderPartial('_recent_activity', array('model' => $model)); ?>
        <div class="summary-bottom-left">
            <div class="summary-talents" id="summary-talents">
                <ul>
                    <li class="summary-talents-1">
                        <a href="<?=$this->createUrl('/wow/character/talents', array('name' => $model->name, 'realm' => Database::$realm))?>" rel="np" class="active">
                        <span class="inner">
                            <span class="icon">
                                <img src="http://eu.battle.net/wow-assets/static/images/icons/36/<?=$model->talentData['icon']?>.jpg" alt="" />
                                <span class="frame"></span>
                            </span>
                            <span class="roles"></span>
                            <span class="name-build">
                                <span class="name"><?=$model->talentData['name']?></span>
                                <span class="build">
                                    <?=$model->talentData['treeOne']?>
                                    <ins>/</ins>
                                    <?=$model->talentData['treeTwo']?>
                                    <ins>/</ins>
                                    <?=$model->talentData['treeThree']?>
                                </span>
                            </span>
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="summary-health-resource">
                <ul>
                    <li class="health" id="summary-health" data-id="health">
                        <span class="name">Health</span>
                        <span class="value"><?=$model->stats->maxhealth?></span>
                    </li>
                    <li class="resource-<?=$model->powerType?>" id="summary-power" data-id="power-<?=$model->powerType?>">
                        <span class="name"><?=$model::itemAlias('powers', $model->powerType)?></span>
                        <span class="value"><?=$model->powerValue?></span>
                    </li>
                </ul>
            </div>
            <div class="summary-stats-profs-bgs">
                <div class="summary-stats" id="summary-stats">
<?php
switch($this->action->id)
{
    case 'simple': default:
        $this->renderPartial('_stats_simple', array('model' => $model));
        break;
}
?>
                </div>
<?php $this->renderPartial('_bg_professions', array('model' => $model)); ?>
            </div>
        </div>
        <span class="clear"><!-- --></span>
        <div id="summary-raid" class="summary-raid"> 
        <h3 class="category">Рейдовый прогресс</h3> 
        <div class="profile-box-full"> 
 
    <div class="summary-raid-wrapper"> 
 
        <div id="summary-raid-wrapper-table" class="summary-raid-wrapper-table" align="center"> 
 
            <table cellspacing="0"> 
    <tbody> 
        <tr class="icons"> 
            <td></td> 
                <td class="mc expansion-0" data-raid="mc"> 
                    <div class="icon"> 
                            <a href="/wow/zone/molten-core/">ОН</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="ony expansion-0" data-raid="ony"> 
                    <div class="icon"> 
                            <a href="/wow/ru/zone/onyxias-lair/">Они</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="bwl expansion-0" data-raid="bwl"> 
                    <div class="icon"> 
                            <a href="/wow/zone/blackwing-lair/">ЛКТ</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="zg expansion-0" data-raid="zg"> 
                    <div class="icon"> 
                            <a href="/wow/zone/zul-gurub/">ЗГ</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="aq10 expansion-0" data-raid="aq10"> 
                    <div class="icon"> 
                            <a href="/wow/zone/ruins-of-ahnqiraj/">АК10</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="aq40 expansion-0" data-raid="aq40"> 
                    <div class="icon"> 
                            <a href="/wow/zone/ahnqiraj-temple/">АК40</a> 
                    </div> 
                </td> 
                    <td class="spacer"><div></div></td> 
                <td class="nax expansion-0" data-raid="nax"> 
                    <div class="icon"> 
                            <a href="/wow/zone/naxxramas/">Накс</a> 
                    </div> 
                </td> 
            <td class="spacer-edge"><div></div></td> 
        </tr> 
        <tr class="normal"> 
            <td></td> 
    <td data-raid="mc" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="ony" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="bwl" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="zg" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="aq10" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="aq40" class="status status-completed"><div></div></td> 
                    <td></td> 
    <td data-raid="nax" class="status status-incomplete"><div></div></td> 
                    <td></td> 
        </tr> 
    </tbody> 
            </table> 
 
        </div> 
 
    <span class="clear"><!-- --></span> 
    </div> 
 
    <div class="summary-raid-legend"> 
        <span class="completed">Завершено</span> 
        <span class="in-progress">В процессе</span> 
    </div> 
 
    <script type="text/javascript"> 
    //<![CDATA[
        $(document).ready(function() {
            new Summary.RaidProgression({ nTrivialRaids: 21, nOptimalRaids: 4, nChallengingRaids: 0  }, {
        mc: {
            name: "Огненные Недра",
            playerLevel: 60,
            nPlayers: 40,
            location: "Черная гора",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "Рагнарос", nKills: 10 }
]
        },
        ony: {
            name: "Логово Ониксии",
            playerLevel: 80,
            nPlayers: -10,
            location: "Пылевые топи",
            expansion: 2,
            heroicMode: false,
            bosses:     [
            { name: "Ониксия", nKills: 10 }
]
        },
        bwl: {
            name: "Логово Крыла Тьмы",
            playerLevel: 60,
            nPlayers: 40,
            location: "Черная гора",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "Нефариан", nKills: 4 }
]
        },
        zg: {
            name: "Зул Гуруб",
            playerLevel: 80,
            nPlayers: -10,
            location: "Пылевые топи",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "Хаккар", nKills: 10 }
]
        },
        aq10: {
            name: "Руины Ан\'Киража",
            playerLevel: 60,
            nPlayers: 10,
            location: "Силитус",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "Оссириан Неуязвимый", nKills: -1 }
]
        },
        aq40: {
            name: "Храм Ан\'Киража",
            playerLevel: 60,
            nPlayers: 40,
            location: "Силитус",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "К\'Тун", nKills: 1 }
]
        },
        nax: {
            name: "Наксрамас",
            playerLevel: 60,
            nPlayers: 40,
            location: "Драконий Погост",
            expansion: 0,
            heroicMode: false,
            bosses:     [
            { name: "Ануб\'Рекан", nKills: 0 },
            { name: "Великая вдова Фарлина", nKills: 0 },
            { name: "Мексна", nKills: 0 },
            { name: "Лоскутик", nKills: 0 },
            { name: "Гроббулус", nKills: 0 },
            { name: "Глут", nKills: 0 },
            { name: "Таддиус", nKills: 0 },
            { name: "Нот Чумной", nKills: 0 },
            { name: "Хейган Нечестивый", nKills: 0 },
            { name: "Лотхиб", nKills: 0 },
            { name: "Инструктор Разувий", nKills: 0 },
            { name: "Готик Жнец", nKills: 0 },
            { name: "Четыре всадника", nKills: 0 },
            { name: "Сапфирон", nKills: 0 },
            { name: "Кел\'Тузад", nKills: 0 }
]
            }});
        });
    //]]>
    </script> 
                        </div> 
                    </div> 
    </div>
</div>
