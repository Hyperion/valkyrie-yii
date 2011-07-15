<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />

<link rel="stylesheet" type="text/css" media="all" href="/css/local-common/common.css" />
<link rel="stylesheet" type="text/css" media="all" href="/css/account/bnet.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script type="text/javascript">
    //<![CDATA[
    Core.staticUrl = '/wow/static';
    Core.sharedStaticUrl= '/wow/static/local-common';
    Core.baseUrl = '/wow';
    Core.supportUrl = 'http://eu.battle.net/support/';
    Core.secureSupportUrl= 'https://eu.battle.net/support/';
    Core.project = 'wow';
    Core.locale = 'ru-ru';
    Core.buildRegion = 'eu';
    Core.shortDateFormat= 'dd/MM/Y';
    Core.dateTimeFormat = 'dd/MM/yyyy HH:mm';
    Core.loggedIn = false;
    //]]>
</script>
<meta name="title" content="Battle.net" />
</head>
<body>
<div id="layout-top">
    <div class="wrapper">
    <div id="header">
        <div id="search-bar">
            <form action="https://eu.battle.net/search" method="get" id="search-form" autocomplete="off">
            <div>
            <input type="text" name="q" id="search-field" value="Поиск" maxlength="35" alt="Поиск по Battle.net" tabindex="50" accesskey="q" />
            <input type="submit" id="search-button" value="" title="Поиск по Battle.net" tabindex="50" />
            </div>
            </form>
        </div>
        <h1 id="logo"><a href="http://eu.battle.net/" tabindex="50" accesskey="h">Battle.net</a></h1>
        <div id="navigation">
            <div id="page-menu" class="large">
                <h2><a href="/wow/account/index/">Личный кабинет</a></h2>
                <?php $this->widget('WUserMenu', array('items' => $this->menu)); ?>
                <span class="clear"><!-- --></span>
            </div>
            <span class="clear"></span>
        </div>
    </div>
    <div id="service">
    <ul class="service-bar">
        <li class="service-cell service-home">
            <a href="/" tabindex="50" title="Battle.net"> </a>
        </li>
        <li class="service-cell service-welcome">
        <?php if(Yii::app()->user->isGuest): ?>
            <a href="#" onclick='$("#userloginwidget").dialog("open"); return false;'>Авторизуйтесь</a> или <a href="#">создайте новую запись</a>
        <?php else: ?>
            Здравствуйте, <?=Yii::app()->user->name?>! |  <?=CHtml::link('выход', array('/user/auth/logout'), array('tabindex' => 50))?>
        <?php endif; ?>
        </li>
        <li class="service-cell service-account" style="padding-right: 20px;">
            <a href="/wow/account" tabindex="50" accesskey="3">Учетная запись</a>
        </li>
    </ul>
    </div>
    </div>
</div>
<div id="layout-middle">
    <div class="wrapper">
        <div id="content"><?php echo $content; ?></div>
    </div>
</div>
</body>
</html>
