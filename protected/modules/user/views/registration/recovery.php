<?php 
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('UserModule.user', "Restore");

$this->breadcrumbs=array(
	Yii::t('UserModule.user', "Login") => array(Yum::route('{user}/login')),
	Yii::t('UserModule.user', "Restore"));

$this->title = Yii::t('UserModule.user', "Restore"); 
?>
<?php if(Core::hasFlash()) {
echo '<div class="success">';
echo Core::getFlash(); 
echo '</div>';
} else {
?>


<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo Yii::t('UserModule.user', "Please enter your user name or email address."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(Yii::t('UserModule.user', 'Restore')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php } ?>
