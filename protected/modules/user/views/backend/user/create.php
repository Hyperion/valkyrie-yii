<?php
$this->breadcrumbs = array(
        Yii::t('UserModule.user', 'Users') => array('index'),
        Yii::t('UserModule.user', 'Create'));

echo $this->renderPartial('_form', array(
            'model'=>$model,
            'passwordform'=>$passwordform,
            'profile'=>$profile)); ?>
