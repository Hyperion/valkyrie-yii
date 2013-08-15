<?php
$equipList = '';
$count = 0;
foreach ($model->items as $item) {
    if (isset($item['entry']) && $item['can_displayed']) {
        if ($count)
            $equipList .= ',';

        $equipList .= $item['slot'] . ',' . $item['display_id'];
        $count++;
    }
} ?>

<object type="application/x-shockwave-flash" data="http://static.wowhead.com/modelviewer/ModelView.swf" width="100%"
        height="100%">
    <param name="quality" value="high">
    <param name="allowscriptaccess" value="always">
    <param name="allowfullscreen" value="true">
    <param name="menu" value="false">
    <param name="bgcolor" value="#1a0f08">
    <param name="wmode" value="transparent">
    <param name="flashvars"
           value="model=<?= $model::itemAlias('race', $model->race) . $model::itemAlias('gender', $model->gender) ?>&amp;modelType=16&amp;equipList=<?= $equipList ?>&amp;contentPath=http://wow.zamimg.com/modelviewer/">
</object>


