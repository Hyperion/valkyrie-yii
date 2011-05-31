<?php
$this->breadcrumbs = array(
    'Game' => array('/wow'),
    'Characters' => array('/wow/character'),
    Database::$realm.' @ '.$model->name,
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
                <div class="rest">Средний<br />(<span class="equipped">364</span> Экипирован)</div> 
                <div id="summary-averageilvl-best" class="best tip" data-id="averageilvl">365</div> 
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
    </div>
</div>
