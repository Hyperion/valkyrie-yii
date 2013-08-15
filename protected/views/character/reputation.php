<?php
$this->breadcrumbs = array(
    'Characters' => array('/character/'),
    'Valkyrie @ '.$model->name => array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name']),
    'Reputation' => array('/wow/character/reputation', 'realm' => 'Valkyrie', 'name' => $model['name']),
); ?>
<div class="profile-sidebar-anchor">
    <div class="profile-sidebar-outer">
        <div class="profile-sidebar-inner">
            <div class="profile-sidebar-contents">

                <div class="profile-sidebar-crest">
                    <?=CHtml::link('<span class="hover"></span><span class="fade"></span>',
                        array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name']),
                        array(
                            'rel' => 'np',
                            'class' => 'profile-sidebar-character-model',
                            'style' => "background-image: url(/images/wow/2d/inset/{$model['race']}-{$model['gender']}.jpg);",
                        ))?>
                    <div class="profile-sidebar-info">
                        <div class="name">
                            <?=CHtml::link($model['name'], array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name']))?>
                        </div>

                        <div class="under-name color-c<?=$model['class_id']?>">
                            <a href="/wow/game/race/<?=$model['race']?>" class="race"><?=$model['race_text']?></a> -
                            <a href="/wow/game/class/<?=$model['class_id']?>" class="class"><?=$model['class_text']?></a>
                            <span class="level"><strong><?=$model['level']?></strong></span> lvl<span class="comma">,</span>
                        </div>

                        <div class="realm">
                            <span id="profile-info-realm" class="tip" data-battlegroup="Valkyrie">Valkyrie</span>
                        </div>


                    </div>
                </div>

                <?php $this->widget('WProfileSidebarMenu', array(
                    'items' => array(
                        array(
                            'label'=>'Сводка',
                            'url'=>array('/character/simple', 'realm'=>Database::$realm, 'name'=>$model->name)
                        ),
                        array(
                            'label'=>'Таланты',
                            'url'=>array('/character/talents', 'realm'=>Database::$realm, 'name'=>$model->name)
                        ),
                        array(
                            'label'=>'Репутация',
                            'url'=>array('/character/reputation', 'realm'=>Database::$realm, 'name'=>$model->name),
                            'active' => true
                        ),
                        array(
                            'label'=>'PvP',
                            'url'=>array('/character/pvp', 'realm'=>Database::$realm, 'name'=>$model->name)
                        ),
                        array(
                            'label'=>'Лента новостей',
                            'url'=>array('/character/feed', 'realm'=>Database::$realm, 'name'=>$model->name)
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
    <h3 class="category-header"><?php CharacterReputation::getFactionNameFromDB($categoryId); ?></h3>
    <ul class="reputation-entry">
<?php foreach($categories as $subcatId => $subcategories):
    if(isset($subcategories['id'])): ?>
        <li class="faction-details">
        <div class="rank-<?php echo $subcategories['type']; ?>">
            <span class="faction-name"><?php echo $subcategories['name']; ?></span>
            <div class="faction-standing">
                <div class="faction-bar">
                    <div class="faction-score"><?php echo $subcategories['adjusted']; ?>/<?php echo $subcategories['cap']; ?></div>
                    <div class="faction-fill" style="width: <?php echo $subcategories['percent']; ?>%;"></div>
                </div>
            </div>
            <div class="faction-level"><?php echo CharacterReputation::itemAlias('rank', $subcategories['type']); ?></div>
        </div>
        </li>
<?php elseif(isset($subcategories[0])): ?>
        <li class="reputation-subcategory">
        <div class="faction-details faction-subcategory-details ">
            <h4 class="faction-header"><?php echo CharacterReputation::getFactionNameFromDB($subcatId); ?></h4>
            <span class="clear"><!-- --></span>
        </div>
        <ul class="factions">
<?php foreach($subcategories as $catid => $cat): ?>
            <li class="faction-details">
            <div class="rank-<?=$cat['type']?>">
                <span class="faction-name"><?php echo $cat['name']; ?></span>
                <div class="faction-standing">
                    <div class="faction-bar">
                        <div class="faction-score"><?php echo $cat['adjusted']; ?>/<?php echo $cat['cap']; ?></div>
                        <div class="faction-fill" style="width: <?php echo $cat['percent']; ?>%;"></div>
                    </div>
                </div>
                <div class="faction-level"><?php echo CharacterReputation::itemAlias('rank', $cat['type']); ?></div>
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
</div>
