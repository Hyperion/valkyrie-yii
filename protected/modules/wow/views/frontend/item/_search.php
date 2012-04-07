<?php
$form = $this->beginWidget('BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type'   => 'horizontal',
    ));
?>
<table width="100%">
    <tr>
        <td width="50%">
            <?php echo $form->textFieldRow($model, 'name'); ?>
            <div class="control-group">
                <label class="control-label" for="ItemTemplate_ItemLevel">
                    <?php echo $model->getAttributeLabel('ItemLevel'); ?>
                </label>
                <div class="controls">
                    <?php echo $form->textField($model, 'minlvl', array('style' => 'width: 94px')); ?> - 
                    <?php echo $form->textField($model, 'maxlvl', array('style' => 'width: 94px')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="ItemTemplate_RequiredLevel">
                    <?php echo $model->getAttributeLabel('RequiredLevel'); ?>
                </label>
                <div class="controls">
                    <?php echo $form->textField($model, 'minrlvl', array('style' => 'width: 94px')); ?> - 
                    <?php echo $form->textField($model, 'maxrlvl', array('style' => 'width: 94px')); ?>
                </div>
            </div>
        </td>
        <td width="50%">
            <select name="ItemTemplate[type][]" size="8" multiple="multiple">
                <option value="15">Daggers</option>
                <option value="13">Fist Weapons</option>
                <option value="0">One-Handed Axes</option>
                <option value="4">One-Handed Maces</option>
                <option value="7">One-Handed Swords</option>
                <option value="6">Polearms</option>
                <option value="10">Staves</option>
                <option value="1">Two-Handed Axes</option>
                <option value="5">Two-Handed Maces</option>
                <option value="8">Two-Handed Swords</option>
                <option value="2">Bows</option>
                <option value="18">Crossbows</option>
                <option value="3">Guns</option>
                <option value="16">Thrown</option>
                <option value="19">Wands</option>
                <option value="20">Fishing Poles</option>
                <option value="14">Miscellaneous (Weapons)</option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class="form-actions">
                <?php echo CHtml::submitButton('Search', array('class' => 'btn')); ?>
            </div></td>
    </tr>
</table>

<?php $this->endWidget(); ?>
