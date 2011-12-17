<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'characters-form',
        'enableAjaxValidation' => false,
            ));
    ?>
    <table>
        <tr>
            <td colspan="2"><div class="row">
                    <p class="note">Fields with <span class="required">*</span> are required.</p>
                    <?php echo $form->errorSummary($model); ?>
                </div></td>
        </tr>
        <tr>
            <td width="50%">
                <?php echo $form->labelEx($model, 'account'); ?>
                <?php echo $form->textField($model, 'account', array('class' => 'text-input large-input')); ?>
                <?php echo $form->error($model, 'account'); ?>
            </td>
            <td width="50%"><div class="row">
                    <?php echo $form->labelEx($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input large-input')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'race'); ?>
                    <?php
                    echo $form->dropDownList($model, 'race', array(
                        '1' => 'Human',
                        '2' => 'Orc',
                        '3' => 'Dwarf',
                        '4' => 'Night Elf',
                        '5' => 'Undead',
                        '6' => 'Tauren',
                        '7' => 'Gnome',
                        '8' => 'Troll'));
                    ?>
                    <?php echo $form->error($model, 'race'); ?>
                </div></td>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'class'); ?>
                    <?php
                    echo $form->dropDownList($model, 'class', array(
                        '1' => 'Warrior',
                        '2' => 'Paladin',
                        '3' => 'Hunter',
                        '4' => 'Rogue',
                        '5' => 'Priest',
                        '7' => 'Shaman',
                        '8' => 'Mage',
                        '9' => 'Warlock',
                        '11' => 'Druid'));
                    ?>
                    <?php echo $form->error($model, 'class'); ?>
                </div></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'gender'); ?>
                    <?php
                    echo $form->dropDownList($model, 'gender', array(
                        '0' => 'Male',
                        '1' => 'Female'));
                    ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </div></td>
            <td></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'level'); ?>
                    <?php echo $form->textField($model, 'level', array('class' => 'text-input large-input')); ?>
                    <?php echo $form->error($model, 'level'); ?>
                </div></td>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'money'); ?>
                    <?php echo $form->textField($model, 'money', array('class' => 'text-input large-input')); ?>
                    <?php echo $form->error($model, 'money'); ?>
                </div></td>
        </tr>
        <tr>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'playerBytes'); ?>
                    <?php
                    echo $form->textField($model, 'playerBytes', array(
                        'readonly' => 'readonly',
                        'class' => 'text-input large-input'
                    ));
                    ?>
                    <?php echo $form->error($model, 'playerBytes'); ?>
                </div></td>
            <td><div class="row">
                    <?php echo $form->labelEx($model, 'playerBytes2'); ?>
                    <?php
                    echo $form->textField($model, 'playerBytes2', array(
                        'readonly' => 'readonly',
                        'class' => 'text-input large-input'
                    ));
                    ?>
                    <?php echo $form->error($model, 'playerBytes2'); ?>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><div class="row">
                    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
                </div>
            </td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>
</div>
