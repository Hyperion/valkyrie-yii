<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm.' @ '.$model->name => array('/wow/character/simple', 'realm' => Database::$realm, 'name' => $model['name']),
    'Reputation' => array('/wow/character/reputation', 'realm' => Database::$realm, 'name' => $model['name']),
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
    ),
)); ?>
            </div>
        </div>
    </div>
</div>
<div class="profile-contents">
    <div class="profile-section-header">
        <h3 class="category ">PvP</h3>
    </div>

    <div class="profile-section">
    <ul>
    <h4 class="pvp-header">Сегодня</h4>
    <span class="clear"></span>
    <li class="pvp-details">
        <span class="pvp-item">Почетных убийств</span>
        <span class="pvp-value positive"><?=$model->honor->today_hk?></span>
        <span class="clear"></span>
    </li>
    <li class="pvp-details">
        <span class="pvp-item">Не почетных убийств</span>
        <span class="pvp-value negative"><?=$model->honor->today_dk?></span>
        <span class="clear"></span>
    </li>
    <h4 class="pvp-header">Вчера</h4>
    <span class="clear"></span>
    <li class="pvp-details">
        <span class="pvp-item">Почетных убийств</span>
        <span class="pvp-value positive"><?=$model->honor->yesterday_kills?></span>
        <span class="clear"></span>
    </li>
    <li class="pvp-details">
        <span class="pvp-item">Очки чести</span>
        <span class="pvp-value neutral"><?=$model->honor->yesterday_cp?></span>
        <span class="clear"></span>
    </li>
    <h4 class="pvp-header">Эта неделя</h4>
    <span class="clear"></span>
    <li class="pvp-details">
        <span class="pvp-item">Почетных убийств</span>
        <span class="pvp-value positive"><?=$model->honor->thisWeek_kills?></span>
        <span class="clear"></span>
    </li>
    <li class="pvp-details">
        <span class="pvp-item">Очки чести</span>
        <span class="pvp-value neutral"><?=$model->honor->thisWeek_cp?></span>
        <span class="clear"></span>
    </li>
    <h4 class="pvp-header">Предидущая неделя</h4>
    <span class="clear"></span>
    <li class="pvp-details">
        <span class="pvp-item">Почетных убийств</span>
        <span class="pvp-value positive"><?=$model->honor->lastWeek_kills?></span>
        <span class="clear"></span>
    </li>
    <li class="pvp-details">
        <span class="pvp-item">Очки чести</span>
        <span class="pvp-value neutral"><?=$model->honor->lastWeek_cp?></span>
        <span class="clear"></span>
    </li>
        <li class="pvp-details">
        <span class="pvp-item">Положение</span>
        <span class="pvp-value neutral"><?=$model->honor_standing?></span>
        <span class="clear"></span>
    </li>
    <h4 class="pvp-header">Игровое время</h4>
    <span class="clear"></span>
    <li class="pvp-details">
        <span class="pvp-item">Почетных убийств</span>
        <span class="pvp-value positive"><?=$model->honor->hk?></span>
        <span class="clear"></span>
    </li>
    <li class="pvp-details">
        <span class="pvp-item">Не почетных убийств</span>
        <span class="pvp-value negative"><?=$model->honor->dk?></span>
        <span class="clear"></span>
    </li>
        </li>
        <li class="pvp-details">
        <span class="pvp-item">Высший ранг</span>
        <span class="pvp-value neutral"><?=$model->getTitle($model->honor_highest_rank)?></span>
        <span class="clear"></span>
    </li>
    </ul>
    </div>
</div>
