<?php
echo '<p>'. Yii::t('UserModule.user', 'This users have visited your profile recently') . ': </p>';

	if($visits) {
		foreach($visits as $visit)
			printf('<div style="text-align:center; float:left; width:100px; padding-bottom:10px;">%s <br/> %s</div>', 
					CHtml::link($visit->visitor->getAvatar(true), array(
							$this->module->profileView, 'id' => $visit->visitor_id)),
							
							
						substr($visit->visitor->username,0,12)
								
								
								
								);
					} else
					echo Yii::t('UserModule.user', 'Nobody has visited your profile yet');
					?>

<div style="clear: both;"> </div>
