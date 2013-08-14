<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm . ' @ ' . $model->name => array('/wow/character/view', 'realm' => Database::$realm, 'name'  => $model['name']),
    'Лента новостей',
);
?>


<h3>Лента новостей</h3>

<ul>
    <?php
    $i      = 0;
    foreach($model->getFeed(50) as $event):
        switch($event['type'])
        {
            case 2:
                ?>
                <li>
                    <dl>
                        <dd>
                            <a href="/wow/item/<?php echo $event['data']; ?>" class="color-q<?php echo $event['item']->Quality; ?>">
                                <span style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/<?php echo $event['item']->icon; ?>.jpg");'></span></a>
                            Получено <a href="/wow/item/<?php echo $event['data']; ?>" class="color-q<?php echo $event['item']->Quality; ?>"><?php echo $event['item']->name; ?></a>
                        </dd>
                        <dt><?php echo date('d/m/Y', $event['date']); ?></dt>
                    </dl>
                </li>
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
        $i++;
    endforeach;
    ?>
</ul>
<div>Отображаются <?php echo $i; ?> последних событий, связанных с персонажем.</div>
