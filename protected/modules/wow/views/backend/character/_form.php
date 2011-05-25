<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'characters-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'account'); ?>
        <?php echo $form->textField($model,'account',array('size'=>11,'maxlength'=>11)); ?>
        <?php echo $form->error($model,'account'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>12,'maxlength'=>12)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'race'); ?>
        <?php echo $form->dropDownList($model,'race', array(
            '1' => 'Human',
            '2' => 'Orc',
            '3' => 'Dwarf',
            '4' => 'Night Elf',
            '5' => 'Undead',
            '6' => 'Tauren',
            '7' => 'Gnome',
            '8' => 'Troll')); ?>
        <?php echo $form->error($model,'race'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'class'); ?>
        <?php echo $form->dropDownList($model,'class', array(
            '1' => 'Warrior',
            '2' => 'Paladin',
            '3' => 'Hunter',
            '4' => 'Rogue',
            '5' => 'Priest',
            '7' => 'Shaman',
            '8' => 'Mage',
            '9' => 'Warlock',
            '11' => 'Druid')); ?>
        <?php echo $form->error($model,'class'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'gender'); ?>
        <?php echo $form->dropDownList($model,'gender', array(
            '0' => 'Male',
            '1' => 'Female')); ?>
        <?php echo $form->error($model,'gender'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'level'); ?>
        <?php echo $form->textField($model,'level'); ?>
        <?php echo $form->error($model,'level'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'money'); ?>
        <?php echo $form->textField($model,'money', array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'money'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'playerBytes'); ?>
        <?php echo $form->textField($model,'playerBytes', array('readonly' => 'readonly')); ?>
        <?php echo $form->error($model,'playerBytes'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'playerBytes2'); ?>
        <?php echo $form->textField($model,'playerBytes2', array('readonly' => 'readonly')); ?>
        <?php echo $form->error($model,'playerBytes2'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
    </div>

<?php $this->endWidget(); ?>
</div>