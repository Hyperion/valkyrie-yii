<?php
$this->title = Yii::t('UserModule.user', 'Friendship administration');
$this->breadcrumbs = array('Friends', 'Admin');

printf('<p>%s</p>', Yii::t('UserModule.user', 'All friendships in the system'));

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$friendships,
	'enableSorting' => true,
	'enablePagination' => true,
	'filter' => new YumFriendship(),
	'columns' => array(
		array(
			'header' => Yii::t('UserModule.user', 'User'),
			'name' => 'inviter_id',
			'value' => '$data->inviter->username'),
		array(
			'header' => Yii::t('UserModule.user', 'is friend of'),
			'name' => 'friend_id',
			'value' => '$data->invited->username'),
		array(
			'header' => Yii::t('UserModule.user', 'Requesttime'),
			'name' => 'requesttime',
			'value' => 'date($this->module->dateTimeFormat, $data->requesttime)'),
		array(
			'header' => Yii::t('UserModule.user', 'Acknowledgetime'),
			'name' => 'acknowledgetime',
			'value' => 'date($this->module->dateTimeFormat, $data->acknowledgetime)'),
		array(
			'header' => Yii::t('UserModule.user', 'Last update'),
			'name' => 'updatetime',
			'value' => 'date($this->module->dateTimeFormat, $data->updatetime)'),
		array(
			'header' => Yii::t('UserModule.user', 'Status'),
			'name' => 'status',
			'value' => '$data->getStatus()'),


		))); 

?>

