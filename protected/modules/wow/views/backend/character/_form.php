<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                   => 'characters-form',
        'enableAjaxValidation' => false,
            ));
    ?>
    <table>
        <tr>
            <td colspan="2">
                <p class="note">Fields with <span class="required">*</span> are required.</p>
                <?php echo $form->errorSummary($model); ?>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <?php echo $form->labelEx($model, 'account'); ?>
                <?php echo $form->textField($model, 'account'); ?>
                <?php echo $form->error($model, 'account'); ?>
            </td>
            <td width="50%">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <td>
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
            </td>
            <td>
                <?php echo $form->labelEx($model, 'class'); ?>
                <?php
                echo $form->dropDownList($model, 'class', array(
                    '1'  => 'Warrior',
                    '2'  => 'Paladin',
                    '3'  => 'Hunter',
                    '4'  => 'Rogue',
                    '5'  => 'Priest',
                    '7'  => 'Shaman',
                    '8'  => 'Mage',
                    '9'  => 'Warlock',
                    '11' => 'Druid'));
                ?>
                <?php echo $form->error($model, 'class'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'gender'); ?>
                <?php
                echo $form->dropDownList($model, 'gender', array(
                    '0' => 'Male',
                    '1' => 'Female'));
                ?>
                <?php echo $form->error($model, 'gender'); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'level'); ?>
                <?php echo $form->textField($model, 'level'); ?>
                <?php echo $form->error($model, 'level'); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'money'); ?>
                <?php echo $form->textField($model, 'money'); ?>
                <?php echo $form->error($model, 'money'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'playerBytes'); ?>
                <?php
                echo $form->textField($model, 'playerBytes', array(
                    'readonly' => true,
                ));
                ?>
                <?php echo $form->error($model, 'playerBytes'); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'playerBytes2'); ?>
                <?php
                echo $form->textField($model, 'playerBytes2', array(
                    'readonly' => true,
                ));
                ?>
                <?php echo $form->error($model, 'playerBytes2'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
            </td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>
</div>
