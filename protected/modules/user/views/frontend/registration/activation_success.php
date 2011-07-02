
<h2> <?php echo Yii::t('UserModule.user', 'Your account has been activated'); ?> </h2>

<p> <?php Yii::t('UserModule.user', 'Click {here} to go to the login form', array(
			'{here}' => CHtml::link(Yii::t('UserModule.user', 'here'), array('Yum::module()->loginUrl')
				))); ?> </p>
