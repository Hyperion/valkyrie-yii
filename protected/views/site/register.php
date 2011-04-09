<div class="form">

<?php $activeform=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $activeform->errorSummary($form); ?>

    <div class="row">
        <?php echo $activeform->labelEx($form,'email'); ?>
        <?php echo $activeform->textField($form,'email'); ?>
    </div>

    <div class="row">
        <?php echo $activeform->labelEx($form,'first_name'); ?>
        <?php echo $activeform->textField($form,'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $activeform->labelEx($form,'last_name'); ?>
        <?php echo $activeform->textField($form,'last_name'); ?>
    </div>

    <div class="row">
        <?php echo $activeform->labelEx($form,'password'); ?>
        <?php echo $activeform->passwordField($form,'password'); ?>
    </div>

    <div class="row">
        <?php echo $activeform->labelEx($form,'verifyPassword'); ?>
        <?php echo $activeform->passwordField($form,'verifyPassword'); ?>
    </div>

    <?php if(CCaptcha::checkRequirements()): ?>
    <div class="row">
        <?php echo $activeform->labelEx($form,'verifyCode'); ?>
        <div>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $activeform->textField($form,'verifyCode'); ?>
        </div>
        <div class="hint">Please enter the letters as they are shown in the image above.
        <br/>Letters are not case-sensitive.</div>
    </div>
    <?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->