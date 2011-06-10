<div class="profile-contents">
    <div class="profile-section-header">
        <h3 class="category ">Таланты</h3>
    </div>

        <div class="profile-section">

            <div class="character-talents-wrapper">

    <div id="talentcalc-character" class="talentcalc talentcalc-locked">
<?php foreach($model->talentBuild as $i => $build): ?>
            <div class="talentcalc-tree-wrapper tree-<?=($model->talentData[$i]['name'] != $model->talentData['name']) ? 'non' : ''?>specialization">

    <div class="talentcalc-tree-header" style="visibility: visible; ">
        <span class="icon">
        <span class="icon-frame-treeheader ">
            <img src="http://eu.media.blizzard.com/wow/icons/36/<?=$model->talentData[$i]['icon']?>.jpg" alt="" width="36" height="36" />
            <span class="frame"></span>
        </span>
        </span>
        <span class="points"><?=$model->talentData[$i]['count']?></span>
        <span class="name"><?=$model->talentData[$i]['name']?></span>
        <span class="clear"><!-- --></span>
    </div>

    <div class="talentcalc-tree" style="width: 228px; height: 387px; background-image: url(/images/wow/talents/backgrounds/7.jpg); background-position: -<?=(228 * $i)?>px 0">
        <div class="talentcalc-cells-wrapper">

<?php
$j = 0;
foreach($build as $tal):
    if($tal['points'] == $tal['maxpoints'])
        $class = "talent-full";
    elseif($tal['points'] < $tal['maxpoints'] && $tal['points'] != 0)
        $class = "talent-partial";
    else
        $class = "";
    /* <span class="arrow arrow-down" style="width: 40px; height: 14px; left: 7px; top: -6px;"></span> */
?>
    <div class="talentcalc-cell <?=$class?>" style="left: <?=($tal['x'] * 53)?>px; top: <?=($tal['y'] * 53)?>px;" data-id="<?=$tal['id']?>">
        <span class="icon">
            <span class="texture" style="background-position: -<?=($j++ * 36)?>px -<?=($i * 36)?>px;"></span>

            <span class="frame"></span>
        </span>
        <a href="javascript:;" class="interact"><span class="hover"></span></a>
        <span class="points"><span class="frame"></span><span class="value"><?=$tal['points']?></span></span>
    </div>
<?php endforeach; ?>


        </div>
    </div>

             </div>
<?php endforeach; ?>

    <script type="text/javascript">
    //<![CDATA[
        $(document).ready(function() {
            new TalentCalculator({ id: "character", classId: <?=$model->class?>, calculatorMode: false, petMode: false, build: "", callback: "", nTrees: 3 });
        });
        var MsgTalentCalculator = {
            talents: {
                tooltip: {
                    rank: "Уровень {0} / {1}",
                    primaryTree: "Сначала потратьте {0} очков талантов основной специализации.",
                    reqTree: "Требуется {0} очков в специализации «{1}».",
                    reqTalent: "Требуется {0} очк. в «{1}».",
                    nextRank: "Следующий уровень:",
                    click: "Щелкните, чтобы изучить",
                    rightClick: "Щелкните правой кнопкой мыши, чтобы забыть"
                }
            },
            buttons: {
                overviewPane: {
                    show: "Просмотреть сводку",
                    hide: "Просмотреть таланты"
                }
            },
            info: {
                calcMode: {
                    tooltip: {
                        title: "Режим «Калькулятор»",
                        description: "В этом режиме вы можете редактировать таланты. Это временные правки. Они не отображаются в игре."
                    }
                }
            }
        };
    //]]>
    </script>


            </div>

        </div>

        </div>
