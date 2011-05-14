<?php
$this->title = Yii::t('UserModule.user', 'Sent messages');

$this->breadcrumbs=array(
	Yii::t('UserModule.user', 'Messages')=>array('index'),
	Yii::t('UserModule.user', 'Sent messages'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'yum-sent-messages-grid',
	'dataProvider' => $model->search(true),
	'columns'=>array(
		array(
			'name' => 'to_user_id',
			'type' => 'raw',
			'value' => 'isset($data->to_user) ? CHtml::link($data->to_user->username, array("//user/profile/view", "id" => $data->to_user->username)) : ""',
			),
		array(
			'type' => 'raw',
			'name' => 'title',
			'value' => 'CHtml::link($data->title, array("view", "id" => $data->id))',
		),
		array(
			'name' => 'timestamp',
			'value' => '$data->getDate()',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}',
		),
	),
)); ?>
