<?php
$this->title = Yii::t('UserModule.user', 'Benutzer suchen');
$this->breadcrumbs=array(Yii::t('UserModule.user', 'Benutzer suchen'));

Core::register('js/tooltip.min.js');
Core::register('css/yum.css'); 
?>
<div class="search_options">

<?php echo CHtml::beginForm(); ?>

<div style="float: left;">
<?php
echo CHtml::label(Yii::t('UserModule.user', 'Search for username'), 'search_username') . '<br />';
echo CHtml::textField('search_username',
		$search_username, array(
			'submit' => array('//user/user/browse')));
echo CHtml::submitButton(Yii::t('UserModule.user', 'Search'));
?>

</div>

<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view', 
    'sortableAttributes'=>array(
        'username',
        'lastvisit',
    ),
));

?>

</div>

<div style="clear: both;"> </div>


