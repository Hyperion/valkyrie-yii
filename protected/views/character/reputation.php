<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm.' @ '.$model->name => array('/wow/character/view', 'realm' => Database::$realm, 'name' => $model['name']),
    'Reputation'
); ?>
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
