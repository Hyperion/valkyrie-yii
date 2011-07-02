<?php 
$this->title = Yii::t('UserModule.user', 'Your message has been sent');
$this->breadcrumbs=array(
	Yii::t('UserModule.user', 'Messages')=>array('index'),
	Yii::t('UserModule.user', 'Success'));
?>

<p> <?php echo CHtml::link(Yii::t('UserModule.user', 'Back to inbox'), array('index')); ?> </p> 
