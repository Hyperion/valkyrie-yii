<?php
$form = $this->beginWidget('BootActiveForm', array(
    'id'                   => 'characters-form',
    'enableAjaxValidation' => false,
        ));
?>
<table width="100%">
    <tr>
        <td colspan="2">
            <p class="note">Fields with <span class="required">*</span> are required.</p>
            <?php echo $form->errorSummary($model); ?>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <?php echo $form->textFieldRow($model, 'account'); ?>
        </td>
        <td width="50%">
            <?php echo $form->textFieldRow($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php
            echo $form->dropDownListrow($model, 'race', array(
                '1' => 'Human',
                '2' => 'Orc',
                '3' => 'Dwarf',
                '4' => 'Night Elf',
                '5' => 'Undead',
                '6' => 'Tauren',
                '7' => 'Gnome',
                '8' => 'Troll'));
            ?>
        </td>
        <td>
            <?php
            echo $form->dropDownListRow($model, 'class', array(
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
        </td>
    </tr>
    <tr>
        <td>
            <?php
            echo $form->dropDownListRow($model, 'gender', array(
                '0' => 'Male',
                '1' => 'Female'));
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'level'); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'money'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php
            echo $form->textFieldRow($model, 'playerBytes', array(
                'readonly' => true,
            ));
            ?>
        </td>
        <td>
            <?php
            echo $form->textFieldRow($model, 'playerBytes2', array(
                'readonly' => true,
            ));
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="form-actions">
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-danger')); ?>
            </div>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
