<?php
$form = $this->beginWidget('BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<table width="100%">
    <tr>
        <td width="50%">
            <?php echo $form->textFieldRow($model, 'username'); ?>
        </td>
        <td width="50%">
            <?php
            echo $form->dropDownListRow($model, 'gmlevel', array(
                '0' => 'Player',
                '1' => 'Moderator',
                '2' => 'Game Master',
                '3' => 'Bug Tracker',
                '4' => 'Admin',
                '5' => 'SysOp'));
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'email'); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'last_ip'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'failed_logins'); ?>
        </td>
        <td>
            <?php
            echo $form->dropDownListRow($model, 'locked', array(
                '0' => 'No',
                '1' => 'Yes'));
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'last_login'); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'active_realm_id'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php
            echo $form->dropDownListRow($model, 'locale', array(
                '0' => 'English',
                '8' => 'Russian'));
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><div class="form-actions">
                <?php echo CHtml::submitButton('Search', array('class' => 'btn')); ?>
            </div></td>
    </tr>
</table>

<?php $this->endWidget(); ?>
