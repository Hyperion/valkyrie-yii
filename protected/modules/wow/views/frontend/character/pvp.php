<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm . ' @ ' . $model->name => array('/wow/character/view', 'realm' => Database::$realm, 'name'  => $model['name']),
    'PvP'
);
?>
<h1>PvP</h1>
<?php $bar    = $model->honorBar; ?>
<ul>
    <h4>
        <?php if($model->honorRank > 4): ?>
            <img src="/images/wow/icons/rank/PvPRank0<?php echo $model->honorRank; ?>.png">
        <?php endif; ?>
        Теущий ранг: <?php echo ($model->getPvpTitle($model->honorRank)) ? $model->getPvpTitle($model->honorRank) : 'нет'; ?>
    </h4>
    <div class="progress">
        <div><?php echo $model->honor_rank_points ?>/<?php echo $bar['cap']; ?></div>
        <div class="bar" style="width: <?php echo $bar['percent']; ?>%;"></div>
    </div>
    <h4>Общий прогресс</h4>
    <?php
    if($model->honor_rank_points < 0)
        $percent = 0;
    else
        $percent = round($model->honor_rank_points / 650);
    ?>
    <div class="progress">
        <div><?php echo $model->honor_rank_points; ?>/65000</div>
        <div class="bar" style="width: <?php echo $percent; ?>%;"></div>
    </div>
    <h4>Сегодня</h4>
    <li>
        <span>Почетных убийств</span>
        <span><?php echo $model->honor->today_hk; ?></span>
    </li>
    <li>
        <span>Не почетных убийств</span>
        <span><?php echo $model->honor->today_dk; ?></span>
    </li>
    <h4>Вчера</h4>
    <li>
        <span>Почетных убийств</span>
        <span><?php echo $model->honor->yesterday_kills; ?></span>
    </li>
    <li>
        <span>Очки чести</span>
        <span><?php echo $model->honor->yesterday_cp; ?></span>
    </li>
    <h4>Эта неделя</h4>
    <li>
        <span>Почетных убийств</span>
        <span><?php echo $model->honor->thisWeek_kills; ?></span>
    </li>
    <li>
        <span>Очки чести</span>
        <span><?php echo $model->honor->thisWeek_cp; ?></span>
    </li>
    <h4>Предыдущая неделя</h4>
    <li>
        <span>Почетных убийств</span>
        <span><?php echo $model->honor->lastWeek_kills; ?></span>
    </li>
    <li>
        <span>Очки чести</span>
        <span><?php echo $model->honor->lastWeek_cp; ?></span>
    </li>
    <li>
        <span>Положение</span>
        <span><?php echo $model->honor_standing; ?></span>
    </li>
    <h4>Игровое время</h4>
    <li>
        <span>Почетных убийств</span>
        <span><?php echo $model->honor->hk; ?></span>
    </li>
    <li>
        <span>Не почетных убийств</span>
        <span><?php echo $model->honor->dk; ?></span>
    </li>
    <li>
        <span>Высший ранг</span>
        <span><?php echo $model->getPvpTitle($model->honor_highest_rank); ?></span>
    </li>
</ul>
