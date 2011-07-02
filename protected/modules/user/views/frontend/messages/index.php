<?php
$this->breadcrumbs=array(
		Yii::t('UserModule.user', 'Messages')=>array('index'),
		Yii::t('UserModule.user', 'My inbox'));

echo Core::renderFlash();

$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'yum-messages-grid',
			'dataProvider' => $model->search(),
			'columns'=>array(
				array(
					'type' => 'raw',
					'name' => Yii::t('UserModule.user', 'From'),
					'value' => 'CHtml::link($data->from_user->username, array(
							"/user/profile",
							"id" => $data->from_user_id))',
				),
				array(
					'type' => 'raw',
					'name' => Yii::t('UserModule.user', 'title'),
					'value' => 'CHtml::link($data->getTitle(), array("view", "id" => $data->id))',
				),
				array(
					'name' => 'timestamp',
					'value' => '$data->getDate()',
				),
				array(
					'class'=>'CButtonColumn',
					'template' => '{view}{delete}',
					),
				),
				)); ?>
