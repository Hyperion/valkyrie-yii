<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id,
);
?>
<div class="dashboard wowc">
<div class="primary">
<div class="header">
<h2 class="subcategory">Управление игрой</h2>
<h3 class="headline">World of Warcraft®</h3>
<a href="<?=$this->createUrl('dashboard', array('name' => $model->username))?>">
<img src="/images/local-common/game-icons/wowc.png?v17" alt="World of Warcraft®" title="" width="48" height="48" />
</a>
</div>
<div class="account-summary">
<div class="account-management">
<div class="section box-art" id="box-art">
<img src="/images/local-common/game-boxes/<?=Yii::app()->language?>/wowc-big.png?v17" alt="World of Warcraft®" title="" width="242" height="288" id="box-img" />
</div>
<div class="section account-details">
<dl>
<dt class="subcategory">Название учетной записи</dt>
<dd class="account-name"><?=strtoupper($model->username)?></dd>
<dt class="subcategory">Состояние:</dt>
<dd class="account-status">
<span>
    <strong class="<?=($model->locked) ? 'frozen' : 'active'; ?>">
    <?=($model->locked) ? 'Закрыта' : 'Активна'?>
    </strong>
</span>
</dd>
<dt class="subcategory">Регион</dt>
<dd class="region eu">(EU)</dd>
</dl>
</div>
<div class="section available-actions">
<ul class="game-time">
<li class="buy-time">
<a href="#" onclick="DashboardForm.show($('#change-password')); return false;">Смена пароля</a>
</li>
<li class="buy-time">
<a href="#" onclick="DashboardForm.show($('#change-locale')); return false;">Смена локализации</a>
</li>
<li class="download-client">
<a href="<?=$this->createUrl('download')?>">Загрузить клиент игры</a>
</li>
</ul>
</div>
</div>

<?php $this->renderPartial('_form_change_password', array('model' => $change_password_form)); ?>
<?php $this->renderPartial('_form_change_locale', array('model' => $model)); ?>

</div>
</div>
<div class="secondary">
<div class="service-selection character-services">
<ul class="wow-services">
<li class="category"><a href="#character-services" class="character-services">Услуги для персонажей</a></li>
<li class="category"><a href="#additional-services" class="additional-services">Дополнительные услуги</a></li>
<li class="category"><a href="#referrals-rewards" class="referrals-rewards">Приглашения и награды</a></li>
<li class="category"><a href="#game-time-subscriptions" class="game-time-subscriptions">Игровое время и подписка</a></li>
</ul>
<div class="service-links">
<div class="position"></div>
<div class="content character-services" id="character-services">
<ul>
<li class="wow-service pct">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Перенос персонажа</strong>
Перенесите персонажа в другой игровой мир или на другую учетную запись.
</a>
</li>
<li class="wow-service pfc">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Смена фракции</strong>
Смените фракцию своего персонажа (Альянс на Орду или наоборот).
</a>
</li>
<li class="wow-service prc">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Смена расы</strong>
Смените расу вашего персонажа (не меняя фракцию)
</a>
</li>
<li class="wow-service pnc">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Cмена имени</strong>
Переименуйте своего персонажа.
</a>
</li>
<li class="wow-service pcc">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Измени персонажа</strong>
Измените внешний облик и, при желании, имя вашего персонажа.
</a>
</li>
<li class="wow-service char-move">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Поломался персонаж</strong>
Восстанавите застрявшего персонажа.
</a>
</li>
<li class="wow-service ptr-copy">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Юзербар</strong>
Создайте уникальный юзербар для вашего персонажа.
</a>
</li>
</ul>
</div>
<div class="content additional-services" id="additional-services">
<ul>
<!--
<li class="wow-service ptr-copy">
<a href="https://www.wow-europe.com/ptr/?accountName=<?=strtoupper($model->username)?>&amp;locale=ru_RU">
<span class="icon glow-shadow-3"></span>
</a>
</li>
<li class="wow-service arena-tournament-closed">
<a href="" onclick="return Core.open(this);">
<span class="icon glow-shadow-3"></span>
</a>
</li>
<li class="wow-service parental-controls">
<a href="/account/parental-controls/index.html">
<span class="icon glow-shadow-3"></span>
</a>
</li>
--!>
</ul>
</div>
<div class="content referrals-rewards" id="referrals-rewards">
<ul>
<li class="wow-service raf">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>Пригласить друга</strong>
Пригласите в игру друзей и получите в подарок награды и пр.
</a>
</li>
<!--
<li class="wow-service resurrection-scroll">
<a href="/account/management/wow/services/sor-invite.html?l=<?=strtoupper($model->username)?>&amp;r=EU">
<span class="icon glow-shadow-3"></span>
</a>
</li>--!>
</ul>
</div>
<div class="content game-time-subscriptions" id="game-time-subscriptions">
<ul>
<!--<li class="wow-service add-game-card">
<a href="https://www.wow-europe.com/account/gamecard.html?accountName=<?=strtoupper($model->username)?>">
<span class="icon glow-shadow-3"></span>
</a>
</li>--!>
<li class="wow-service wow-anywhere">
<a href="#">
<span class="icon glow-shadow-3"></span>
<strong>World of Warcraft без границ</strong>
Пользуйтесь всеми возможностями Аукциона для Оружейной
</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
