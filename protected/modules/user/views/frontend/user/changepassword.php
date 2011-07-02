<?php 
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('UserModule.user', "change password");
echo '<h2>'. Yii::t('UserModule.user', 'change password') .'</h2>';

$this->breadcrumbs = array(
	Yii::t('UserModule.user', "Profile") => array('profile'),
	Yii::t('UserModule.user', "Change password"));

if(isset($expired) && $expired)
	$this->renderPartial('password_expired');
?>

<div class="form">
<?php echo CHtml::beginForm(); ?>
	<?php echo Core::requiredFieldNote(); ?>
	<?php echo CHtml::errorSummary($form); ?>

	<?php if(!Yii::app()->user->isGuest) {
		echo '<div class="row">';
		echo CHtml::activeLabelEx($form,'currentPassword'); 
		echo CHtml::activePasswordField($form,'currentPassword'); 
		echo '</div>';
	} ?>

	<?php $this->renderPartial('/user/passwordfields', array('form'=>$form)); ?>
	
	<div class="row submit">
	<?php echo CHtml::submitButton(Yii::t('UserModule.user', "Save")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
