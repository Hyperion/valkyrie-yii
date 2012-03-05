<h3>Последние новости</h3>
<ul>
    <?php
    foreach($model->getFeed(5) as $event)
        switch($event['type'])
        {
            case 2:
                ?>
                <li><dl>
                        <dd>
                            <a href="/wow/item/<?php echo $event['data']; ?>" class="color-q<?php echo $event['item']->Quality; ?>">
                                <span style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/<?php echo $event['item']->icon; ?>.jpg");'></span></a>
                            Получено <a href="/wow/item/<?php echo $event['data']; ?>" class="color-q<?php echo $event['item']->Quality; ?>"><?php echo $event['item']->name; ?></a>
                        </dd>
                        <dt><?php echo date('d/m/Y', $event['date']); ?></dt>
                    </dl></li>
                <?php
                break;
            case 3:
                ?>
                <li>
                    <dl>
                        <dd><?php echo $event['count']; ?> <?php echo CHtml::link($event['data']->name, array('/wow/creature/view', 'id' => $event['data']->entry)); ?> <?php echo ($event['count'] > 1) ? 'убийств' : 'убийство'; ?></dd>
                        <dt><?php echo date('d/m/Y', $event['date']); ?></dt>
                    </dl>
                </li>
                <?php
                break;
        }
    ?>
</ul>
<a href="/wow/character/feed/<?php echo Database::$realm ?>/<?php echo $model->name ?>">Смотреть более ранние новости</a>