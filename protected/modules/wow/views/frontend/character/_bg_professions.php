<ul>
    <li>
        <span>PvP Rank</span>
        <span>
            <?php if($model->honorRank > 4): ?>
                <img src="/images/wow/icons/rank/PvPRank0<?php echo $model->honorRank; ?>.png">
            <?php else: ?>
                нет
            <?php endif; ?>
        </span>
    </li>
    <li class="kills">
        <span>Honorable Kills</span>
        <span><?php echo $model->honor->hk; ?></span>
    </li>
</ul>
<ul>
    <?php
// Professions
    $professions = $model->professions;
    if(is_array($professions))
        for($i = 0; $i < 2; $i++)
            if(!isset($professions[$i])): ?>
                <li>
                    <span class="icon"> 
                        <img src="http://eu.battle.net/wow-assets/static/images/icons/18/inv_misc_questionmark.jpg" width="12" height="12" />
                    </span>
                    <span>No profession</span>
                </li>
            <?php else: ?>
                <li><div class="progress">
                        <div class="bar" style="width: <?php echo ($professions[$i]['value'] / 3); ?>%"></div>
                        <div>
                            <span> 
                                <img src="http://eu.battle.net/wow-assets/static/images/icons/18/<?php echo $professions[$i]['icon']; ?>.jpg" width="12" height="12" />
                            </span>
                            <span><?php echo$professions[$i]['name']; ?></span>
                            <span><?php echo$professions[$i]['value']; ?></span>
                        </div>
                    </div></li>
            <?php endif;  ?>
</ul>
