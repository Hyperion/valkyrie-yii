<?php
$this->breadcrumbs=array(
    'Accounts',
);
?>
<div id="lobby">
<div id="page-content" class="page-content">
<div id="lobby-account">
<h3 class="section-title">Информация о записи</h3>
<div class="lobby-box">
<h4 class="subcategory">Название учетной записи</h4>
<p><?=Yii::app()->user->name?>
<span class="edit">[<a href="#">Редактировать</a>]</span>
</p>
</div>
</div>
<div id="lobby-games">
<h3 class="section-title">Ваши учетные записи для игр</h3>
<div id="games-list">
<?php if(!count(Yii::app()->user->accounts)): ?>
<ul>
<li class="cta border-4">
К этой учетной записи Valkyrie-wow еще не прикреплено ни одной игры.<br />
<?=CHtml::link('Прикрепите свою запись World of Warcraft®', array('add'))?> или <?=CHtml::link('зарегистрируйте новую', array('register'))?>
</li>
</ul>
<?php else: ?>
<a href="#wow" class="games-title border-2 opened" rel="game-list-wow">World of Warcraft</a>
<ul id="game-list-wow">
<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'accounts-list',
    'dataProvider' => Account::userRelated(),
    'itemView'=>'_view',
)); ?>
</ul>
<?php endif; ?>
</div>
<div id="games-tools">
<?=CHtml::link('Прикрепить игру', array('add'), array('id' => 'add-game', 'class' => 'border-5'))?>
<p>
<a href="<?=$this->createUrl('register')?>" class="" onclick="">
<span class="icon-16 icon-account-buy"></span>
<span class="icon-16-label">Зарегистрировать учетную запись</span>
</a>
</p>
<p>
<a href="<?=$this->createUrl('download')?>" class="" onclick="">
<span class="icon-16 icon-account-download"></span>
<span class="icon-16-label">Загрузка игры</span>
</a>
</p>
<p>
<a href="<?=$this->createUrl('redeem')?>" class="" onclick="">
<span class="icon-16 icon-account-add"></span>
<span class="icon-16-label">Эксклюзивный предмет</span>
</a>
</p>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="/account/local-common/js/locales/.js"></script>
