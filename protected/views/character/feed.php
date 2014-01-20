<?php
$this->breadcrumbs = array(
    'Characters' => array('/character/'),
    'Valkyrie @ ' . $model->name => array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name']),
    'Лента новостей' => array('/character/feed', 'realm' => 'Valkyrie', 'name' => $model['name']),
); ?>
<div class="profile-sidebar-anchor">
    <div class="profile-sidebar-outer">
        <div class="profile-sidebar-inner">
            <div class="profile-sidebar-contents">

                <div class="profile-sidebar-crest">
                    <?=
                    CHtml::link('<span class="hover"></span><span class="fade"></span>',
                        array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name']),
                        array(
                            'rel' => 'np',
                            'class' => 'profile-sidebar-character-model',
                            'style' => "background-image: url(/images/wow/2d/inset/{$model['race']}-{$model['gender']}.jpg);",
                        ))?>
                    <div class="profile-sidebar-info">
                        <div class="name">
                            <?= CHtml::link($model['name'], array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model['name'])) ?>
                        </div>

                        <div class="under-name color-c<?= $model['class_id'] ?>">
                            <a href="/game/race/<?= $model['race'] ?>" class="race"><?= $model['race_text'] ?></a> -
                            <a href="/game/class/<?= $model['class_id'] ?>"
                               class="class"><?= $model['class_text'] ?></a>
                            <span class="level"><strong><?= $model['level'] ?></strong></span> lvl<span
                                class="comma">,</span>
                        </div>

                        <div class="realm">
                            <span id="profile-info-realm" class="tip" data-battlegroup="Valkyrie">Valkyrie</span>
                        </div>


                    </div>
                </div>

                <?php $this->widget('WProfileSidebarMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Сводка',
                            'url' => array('/character/simple', 'realm' => 'Valkyrie', 'name' => $model->name)
                        ),
                        array(
                            'label' => 'Таланты',
                            'url' => array('/character/talents', 'realm' => 'Valkyrie', 'name' => $model->name)
                        ),
                        array(
                            'label' => 'Репутация',
                            'url' => array('/character/reputation', 'realm' => 'Valkyrie', 'name' => $model->name)
                        ),
                        array(
                            'label' => 'PvP',
                            'url' => array('/character/pvp', 'realm' => 'Valkyrie', 'name' => $model->name)
                        ),
                        array(
                            'label' => 'Лента новостей',
                            'url' => array('/character/feed', 'realm' => 'Valkyrie', 'name' => $model->name),
                            'active' => true
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
            $i = 0;
            foreach ($model->getFeed(50) as $event):
                switch ($event['type']) {
                    case 2:
                        ?>
                        <li>
                            <dl>
                                <dd><a href="<?= Yii::app()->request->baseUrl ?>/item/<?= $event['data'] ?>" class="color-q<?= $event['item']->Quality ?>"
                                       data-item="">
                                        <span class="icon-frame frame-18"
                                              style='background-image: url("http://media.blizzard.com/wow/icons/18/<?= $event['item']->icon ?>.jpg");'></span></a>
                                    Получено <a href="<?= Yii::app()->request->baseUrl ?>/item/<?= $event['data'] ?>"
                                                class="color-q<?= $event['item']->Quality ?>"
                                                data-item=""><?= $event['item']->name ?></a>
                                </dd>
                                <dt><?= date('d/m/Y', $event['date']) ?></dt>
                            </dl>
                        </li>
                        <?php
                        break;
                    case 3:
                        ?>
                        <li class="bosskill">
                            <dl>
                                <dd><span
                                        class="icon"></span><?= $event['count'] ?> <?= CHtml::link($event['data']->name, array('/creature/view', 'id' => $event['data']->entry)) ?> <?= ($event['count'] > 1) ? 'убийств' : 'убийство' ?>
                                </dd>
                                <dt><?= date('d/m/Y', $event['date']) ?></dt>
                            </dl>
                        </li>
                        <?php
                        break;
                }
                $i++;
            endforeach;
            ?>
        </ul>
        <div class="activity-note">Отображаются <?= $i ?> последних событий, связанных с персонажем.</div>
    </div>
</div>
