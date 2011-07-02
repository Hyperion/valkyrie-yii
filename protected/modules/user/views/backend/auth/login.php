<div id="login-wrapper" class="png_bg">
    <div id="login-top">
    <h2>Login to admin panel</h2>
    </div> <!-- End #logn-top -->

    <div id="login-content">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p>
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username', array('class' => 'text-input')); ?>
    </p>
    <div class="clear"></div>
    <p>
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password', array('class' => 'text-input')); ?>
    </p>
    <div class="clear"></div>
    <p>
        <?php echo CHtml::submitButton('Sign in', array('class' => 'button')); ?>
    </p>

    <?php $this->endWidget(); ?>

    </div> <!-- End #login-content -->

</div> <!-- End #login-wrapper -->
