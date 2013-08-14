<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/local-common/common.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/wow/wow.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
<body class="<?=$this->body_class?>">
<div id="wrapper">
    <div id="header">
        <div id="search-bar">
        <form action="/wow/search" method="get" id="search-form">
        <div>
        <input type="submit" id="search-button" value="" tabindex="41"/>
        <input type="text" name="q" id="search-field" maxlength="200" tabindex="40" alt="Search characters, items, forums and more…" value="Search characters, items, forums and more…" />
        </div>
        </form>
        </div>

        <h1 id="logo"><a href="/">World of Warcraft</a></h1>

        <div class="header-plate">
        <div class="user-plate ajax-update">
        <a href="?login" class="card-login"
        onclick="BnetAds.trackImpression('Battle.net Login', 'Character Card', 'New'); return Login.open('https://eu.battle.net/login/login.frag');">
        <strong>Log in now</strong> to enhance and personalize your experience!
        </a>
        <div class="card-overlay"></div>
        </div>
    </div>
</div>
    <div id="content">
        <div class="content-top">
            <div class="content-trail">
<?php
$this->widget('WBreadcrumbs', array(
    'links'=>$this->breadcrumbs,
    'htmlOptions' => array('class' => 'ui-breadcrumb'),
));
?>
            </div>
            <div class="content-bot"><?php echo $content; ?></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/local-common/menu.js"></script>
<script type="text/javascript">
friendData = [
];
$(function(){
//
Menu.initialize('/data/menu.json');
});
</script>
    </body>
</html>
