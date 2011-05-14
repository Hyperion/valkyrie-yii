<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>rand(1, 999999),
				'options'=>array(
					'show' => 'blind',
					'hide' => 'explode',
					'modal' => 'false',
					'width' => '800px',
					'title' => Yii::t('UserModule.user', 'You have {count} new Messages !', array(
							'{count}' => count($messages))),
						'autoOpen'=>true,
					),
				));

echo '<table>';
	printf('<tr><th>%s</th><th>%s</th><th>%s</th><th colspan = 2>%s</th></tr>',
		Yii::t('UserModule.user', 'From'),
		Yii::t('UserModule.user', 'Date'),
		Yii::t('UserModule.user', 'Title'),
		Yii::t('UserModule.user', 'Actions'));
	
	foreach($messages as $message) {
		if(is_object($message) && $message->from_user instanceof YumUser )
				printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
					CHtml::link($message->from_user->username, array('//user/profile/view', 'id' => $message->from_user_id)),
					date($this->module->dateTimeFormat, $message->timestamp),
					CHtml::link($message->title, array('//user/messages/view', 'id' => $message->id)),
					CHtml::link(Yii::t('UserModule.user', 'View'), array('//user/messages/view', 'id' => $message->id)),
					CHtml::link(Yii::t('UserModule.user', 'Reply'), array('//user/messages/compose', 'to_user_id' => $message->from_user_id)));


				}
				echo '</table>';
				$this->endWidget('zii.widgets.jui.CJuiDialog');
				?>
