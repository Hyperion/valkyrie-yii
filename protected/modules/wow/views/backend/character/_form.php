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
            <?php echo $form->dropDownListrow($model, 'race', Character::itemAlias('race')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model, 'class', Character::itemAlias('class')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'gender', Character::itemAlias('gender')); ?>
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
