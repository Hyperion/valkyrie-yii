<?php
$this->breadcrumbs=array(
    'Characters'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'List Characters', 'url'=>array('index')),
    array('label'=>'Update Characters', 'url'=>array('update', 'id'=>$model->guid)),
    array('label'=>'Manage Characters', 'url'=>array('admin')),
);
?>

<div class="profile-info-anchor">
    <div class="profile-info">
    <div class="name"><a href="/wow/character/<?php echo $model->guid; ?>" rel="np"><?php echo $model->name; ?></a></div>
    <?php if($model->guildId): ?>
    <div class="guild"><a href="/wow/guild/<?php echo $model->guildId; ?>"><?php echo $model->guildName; ?></a></div>
    <?php endif; ?>
    <span class="clear"><!-- --></span>
    <div class="under-name color-c<?php echo $model->class; ?>">
        <a href="/wow/game/race/<?php $model->race; ?>" class="race"><?php echo $model->raceText; ?></a>-<a href="/wow/game/class/<?php echo $model->class; ?>" class="class"><?php echo $model->classText; ?></a> (<span id="profile-info-spec" class="spec tip"></span>) <span class="level"><strong><?php echo $model->level; ?></strong></span> lvl<span class="comma">,</span>
        <span class="realm tip" id="profile-info-realm" data-battlegroup="">Valkyrie-wow</span>
    </div>
    </div>
</div>