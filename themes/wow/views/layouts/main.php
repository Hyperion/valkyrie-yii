<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />

<link rel="stylesheet" type="text/css" media="all" href="/css/local-common/common.css" />
<link rel="stylesheet" type="text/css" media="all" href="/css/wow/wow.css" />
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
            <?php if(Yii::app()->user->isGuest): ?>
                <a href="#" class="card-login"
                onclick='$("#userloginwidget").dialog("open"); return false;'>
                    <strong>Log in now</strong> to enhance and personalize your experience!
                </a>
            <?php endif; ?>
                <div class="card-overlay"></div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="content-top">
            <?php if(!empty($this->breadcrumbs)): ?>
            <div class="content-trail">
<?php
$this->widget('WBreadcrumbs', array(
    'links'=>$this->breadcrumbs,
    'htmlOptions' => array('class' => 'ui-breadcrumb'),
));
?>
            </div>
            <?php endif; ?>
            <div class="content-bot"><?php echo $content; ?></div>
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
            <a href="/account" tabindex="50" accesskey="3">Учетная запись</a>
        </li>
    </ul>
    </div>
    <div id="warnings-wrapper">
    <noscript>
        <div id="javascript-warning" class="warning warning-red">
            <div class="warning-inner2">Для просмотра сайта требуется поддержка JavaScript.</div>
        </div>
    </noscript>
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
<script type="text/javascript">
//<![CDATA[
var xsToken = '';
var Msg = {
support: {
ticketNew: 'Открыт запрос № {0}.',
ticketStatus: 'Запросу № {0} присвоен статус «{1}».',
ticketOpen: 'Открыт',
ticketAnswered: 'Дан ответ',
ticketResolved: 'Разрешен',
ticketCanceled: 'Отменен',
ticketArchived: 'Перемещен в архив',
ticketInfo: 'Уточнить',
ticketAll: 'Все запросы'
},
cms: {
requestError: 'Ваш запрос не может быть завершен.',
ignoreNot: 'Этот пользователь не в черном списке.',
ignoreAlready: 'Этот пользователь уже в черном списке.',
stickyRequested: 'Отправлена просьба прикрепить тему.',
postAdded: 'Сообщение отслеживается',
postRemoved: 'Сообщение больше не отслеживается',
userAdded: 'Сообщения пользователя отслеживаются',
userRemoved: 'Сообщения пользователя больше не отслеживается',
validationError: 'Обязательное поле не заполнено',
characterExceed: 'В сообщении превышено допустимое число символов.',
searchFor: "Поиск по",
searchTags: "Помеченные статьи:",
characterAjaxError: "Возможно, вы вышли из системы. Обновите страницу и повторите попытку.",
ilvl: "Уровень предмета",
shortQuery: "Запрос для поиска должен состоять не менее чем из двух букв."
},
bml: {
bold: 'Полужирный',
italics: 'Курсив',
underline: 'Подчеркивание',
list: 'Несортированный список',
listItem: 'Список',
quote: 'Цитирование',
quoteBy: 'Размещено {0}',
unformat: 'Отменить форматирование',
cleanup: 'Исправить переносы строки',
code: 'Код',
item: 'Предмет WoW',
itemPrompt: 'Идентификатор предмета:',
url: 'Адрес',
urlPrompt: 'Адрес страницы:'
},
ui: {
viewInGallery: 'Галерея',
loading: 'Подождите, пожалуйста.',
unexpectedError: 'Произошла ошибка.',
fansiteFind: 'Найти на…',
fansiteFindType: '{0}: поиск на…',
fansiteNone: 'Нет доступных сайтов.'
},
grammar: {
colon: '{0}:',
first: 'Первая стр.',
last: 'Последняя стр.'
},
fansite: {
character: 'Персонаж',
faction: 'Фракция',
'class': 'Класс',
object: 'Объект',
talentcalc: 'Таланты',
skill: 'Профессия',
quest: 'Задание',
spell: 'Заклинания',
event: 'Событие',
title: 'Звание',
guild: 'Гильдия',
zone: 'Территория',
item: 'Предмет',
race: 'Раса',
npc: 'НПС',
pet: 'Питомец'
}
};
//]]>
</script>
<div style="visibility: hidden;">
<?php $this->widget('application.modules.user.components.WUserLogin',array('visible'=>Yii::app()->user->isGuest)); ?>
</div>
</body></html>
