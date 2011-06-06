<?php $this->beginContent('//layouts/main'); ?>
<div id="profile-wrapper" class="profile-wrapper profile-wrapper-<?=Character::itemAlias('factions', $this->_model->faction)?>">
<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>

