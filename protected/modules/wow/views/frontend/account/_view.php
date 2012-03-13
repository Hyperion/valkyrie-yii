<li class="border-4" id="<?=$model->username?>">
<span class="game-icon">
<img src="<?=Yii::app()->request->baseUrl?>/images/local-common/game-icons/wowc-32.png" alt="" width="32" height="32" />
</span>
<span class="account-info">
<span class="account-link">
<strong>
<?=CHtml::link('World of Warcraft&reg;', array('dashboard', 'name' => $model->username))?>
</strong>
<span class="account-id">[<?=strtoupper($model->username)?>] </span>
</span>
</span>
</li>
