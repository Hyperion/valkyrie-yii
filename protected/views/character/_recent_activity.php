<div class="profile-recentactivity">
    <h3 class="category ">Последние новости</h3>

    <div class="profile-box-simple">
        <ul class="activity-feed">
            <?php
            foreach ($model->getFeed(5) as $event)
                switch ($event['type']) {
                    case 2:
                        ?>
                        <li>
                            <dl>
                                <dd><a href="<?= Yii::app()->request->baseUrl ?>/item/<?= $event['data'] ?>"
                                       class="color-q<?= $event['item']->Quality ?>" data-item="">
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
            ?>
        </ul>
        <a class="profile-linktomore" rel="np" href="<?= Yii::app()->request->baseUrl ?>/character/feed/Valkyrie/<?= $model->name ?>">Смотреть более ранние
            новости</a>
        <span class="clear"></span>
    </div>
</div>
