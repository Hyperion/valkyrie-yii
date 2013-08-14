<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm.' @ '.$model->name => array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']),
    'Talents' => array('/wow/character/talent', 'realm' => Database::$realm, 'name' => $model['name']),
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
        <h3 class="category ">Таланты</h3>
    </div>

        <div class="profile-section">

            <div class="character-talents-wrapper">

    <div id="talentcalc-character" class="talentcalc talentcalc-locked">
<?php for($i = 0; $i < 3; $i++) { ?>
            <div class="talentcalc-tree-wrapper<?=($i==2)?" tree-last":""?>">

    <div class="talentcalc-tree-header" style="visibility: visible; ">
        <span class="icon">
        <span class="icon-frame-treeheader ">
            <img src="http://eu.media.blizzard.com/wow/icons/36/<?=$model->talents[$i]['icon']?>.jpg" alt="" width="36" height="36" />
            <span class="frame"></span>
        </span>
        </span>
        <span class="points">
            <span class="value"><?=$model->talents[$i]['count']?></span>
        </span>
        <span class="name"><?=$model->talents[$i]['name']?></span>
        <span class="clear"><!-- --></span>
    </div>

    <div class="talentcalc-tree" style="width: 228px; height: 387px; background-image: url(/images/wow/talents/backgrounds/7.jpg); background-position: -<?=(228 * $i)?>px 0">
        <div class="talentcalc-cells-wrapper">

<?php
$j = 0;
foreach($model->talents[$i]['talents'] as $tal):
    if($tal['points'] == $tal['maxpoints'])
        $class = 'talent-full';
    elseif($tal['points'] < $tal['maxpoints'] && $tal['points'] != 0)
        $class = 'talent-partial';
    else
        $class = '';
    if(isset($tal['req']) && $tal['points'] != 0)
        $class .= ' talent-arrow';
?>
    <div class="talentcalc-cell <?=$class?>" style="left: <?=($tal['x'] * 53)?>px; top: <?=($tal['y'] * 53)?>px;" data-id="<?=$tal['id']?>">
        <span class="icon">
            <span class="texture"></span>
<?php if($tal['keyAbility']): ?>
            <span class="ability"></span>
<?php endif; ?>
            <span class="frame"></span>
        </span>
        <a href="javascript:;" class="interact"><span class="hover"></span></a>
        <span class="points"><span class="frame"></span><span class="value"><?=$tal['points']?></span></span>
<?php if(isset($tal['req'])):

    foreach($model->talents[$i]['talents'] as $prev):
        if($prev['id'] == $tal['req'])
            break;
    endforeach;

    if($tal['x'] == $prev['x'])
    {
        $type = 'down';
        $w = 40;
        $l = 7;
        $h = 14 + ($tal['y'] - $prev['y'] - 1) * 53;
        $t = -6 - ($tal['y'] - $prev['y'] - 1) * 53;
    }
    elseif($tal['x'] > $prev['x'] && $tal['y'] == $prev['y'])
    {
        $type = 'right';
        $h = 40;
        $t = 7;
        $l = -6;
        $w = 13;
    }
    else
    {
        $type = 'right-down';
        $w = 53;
        $l = -6;
        $t = -24;
        $h = 31;
    }


?>
        <span class="arrow arrow-<?=$type?>" style="width: <?=$w?>px; height: <?=$h?>px; left: <?=$l?>px; top: <?=$t?>px;">
        <?php if($type == 'right-down'): ?>
            <ins></ins><em></em>
        <?php endif; ?>
        </span>
<?php endif; ?>
    </div>
<?php endforeach; ?>


        </div>
    </div>

             </div>
<?php } ?>
<span class="clear"><!-- --></span>
<div class="talentcalc-bottom">
    <div class="talentcalc-info">
        <div class="export" style="display: none"><a href="#">Экспортировать</a></div>
        <div class="calcmode"><a href="javascript:;">Режим «Калькулятор»</a></div>
        <div class="restore" style="display: none"><a href="javascript:;">Восстановить</a></div>
        <div class="reset" style="display: none"><a href="javascript:;">Сбросить</a></div>
        <div class="pointsspent" style="display: none"><span class="name">Очков потрачено:</span><span class="value"><span>9</span><ins>/</ins><span>0</span><ins>/</ins><span>32</span></span></div>
        <div class="pointsleft" style="display: none"><span class="name">Очков осталось:</span><span class="value">0</span></div>
        <div class="requiredlevel" style="display: none"><span class="name">Требуемый уровень:</span><span class="value">-</span></div>
    </div>

    <span class="clear"><!-- --></span>
</div>

    <script type="text/javascript">
    //<![CDATA[
        $(document).ready(function() {
            new TalentCalculator({ id: "character", classId: <?=$model->class?>, calculatorMode: false, build: "<?=$model->talents['build']?>", callback: "", nTrees: 3 });
        });
        var MsgTalentCalculator = {
            talents: {
                tooltip: {
                    rank: "Уровень {0} / {1}",
                    primaryTree: "Сначала потратьте {0} очков талантов основной специализации.",
                    reqTree: "Требуется {0} очков в специализации «{1}».",
                    reqTalent: "Требуется {0} очк. в «{1}».",
                    nextRank: "Следующий уровень:",
                    click: "Щелкните, чтобы изучить",
                    rightClick: "Щелкните правой кнопкой мыши, чтобы забыть"
                }
            },
            buttons: {
                overviewPane: {
                    show: "Просмотреть сводку",
                    hide: "Просмотреть таланты"
                }
            },
            info: {
                calcMode: {
                    tooltip: {
                        title: "Режим «Калькулятор»",
                        description: "В этом режиме вы можете редактировать таланты. Это временные правки. Они не отображаются в игре."
                    }
                }
            }
        };
    //]]>
    </script>


            </div>

        </div>

        </div>
