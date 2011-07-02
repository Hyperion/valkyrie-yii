<?php

echo Yii::t('UserModule.user', 'You are not allowed to see this message.');
echo '<br />';
echo CHtml::link(Yii::t('UserModule.user', 'Return to your inbox'), array('index'));

?>
