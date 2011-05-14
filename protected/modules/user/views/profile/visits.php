<?php
$this->title = Yii::t('UserModule.user', 'All Profile visits in the system');

$this->breadcrumbs = array(
	Yii::t('UserModule.user', 'Profiles') => array('index'),
	Yii::t('UserModule.user', 'Profile visits'));

$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$model->search(),
			'columns'=>array(
				array(
					'header' => Yii::t('UserModule.user', 'Visitor'),
					'type' => 'raw',
					'value' => 'CHtml::link($data->visitor->username, array(
							"/user/profile/view",
							"id" => $data->visitor->profile->id))'),
				array(
					'header' => Yii::t('UserModule.user', 'Visited'),
					'type' => 'raw',
					'value' => 'CHtml::link($data->visited->username, array(
							"/user/profile/view",
							"id" => $data->visited->profile->id))'),
				array(
					'name' => 'timestamp_first_visit',
					'filter' => false,
					'value'=>'date(Yii::app()->getModule("user")->dateTimeFormat,
						$data->timestamp_first_visit)',
					),
				array(
					'name'=>'timestamp_last_visit',
					'filter' => false,
					'value'=>'date(Yii::app()->getModule("user")->dateTimeFormat,
						$data->timestamp_last_visit)',
					),
				'num_of_visits',
				))); ?>
