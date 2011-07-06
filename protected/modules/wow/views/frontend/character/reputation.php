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
<div class="reputation reputation-simple" id="reputation">
    <div class="profile-section-header">
        <h3 class="category ">Репутация</h3>
    </div>

    <div class="profile-section">

    <ul class="reputation-list">
<?php foreach($model->factions as $categoryId => $categories): ?>
<li class="reputation-category">
    <h3 class="category-header"><?=CharacterReputation::getFactionNameFromDB($categoryId)?></h3>
    <ul class="reputation-entry">
<?php foreach($categories as $subcatId => $subcategories):
    if(isset($subcategories['id'])): ?>
        <li class="faction-details">
        <div class="rank-<?=$subcategories['type']?>">
            <span class="faction-name"><?=$subcategories['name']?></span>
            <div class="faction-standing">
                <div class="faction-bar">
                    <div class="faction-score"><?=$subcategories['adjusted']?>/<?=$subcategories['cap']?></div>
                    <div class="faction-fill" style="width: <?=$subcategories['percent']?>%;"></div>
                </div>
            </div>
            <div class="faction-level"><?=CharacterReputation::itemAlias('rank', $subcategories['type'])?></div>
            <span class="clear"><!-- --></span>
        </div>
        </li>
<?php elseif(isset($subcategories[0])): ?>
        <li class="reputation-subcategory">
        <div class="faction-details faction-subcategory-details ">
            <h4 class="faction-header"><?=CharacterReputation::getFactionNameFromDB($subcatId)?></h4>
            <span class="clear"><!-- --></span>
        </div>
        <ul class="factions">
<?php foreach($subcategories as $catid => $cat): ?>
            <li class="faction-details">
            <div class="rank-<?=$cat['type']?>">
                <span class="faction-name"><?=$cat['name']?></span>
                <div class="faction-standing">
                    <div class="faction-bar">
                        <div class="faction-score"><?=$cat['adjusted']?>/<?=$cat['cap']?></div>
                        <div class="faction-fill" style="width: <?=$cat['percent']?>%;"></div>
                    </div>
                </div>
                <div class="faction-level"><?=CharacterReputation::itemAlias('rank', $cat['type'])?></div>
                <span class="clear"><!-- --></span>
            </div>
            </li>
<?php endforeach; ?>
        </ul></li>
<?php endif; ?>
<?php endforeach;?>
</ul>
</li>
<?php endforeach; ?>
    </ul>

</div>
</div>
