<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

    <?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>
    <table>
        <tr>
            <td>
                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
            </td>
        </tr>

<?php foreach($this->tableSchema->columns as $column):
            if($column->autoIncrement)
                continue;
            ?>
        <tr>
            <td>
                <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
                <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
                <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
            </td>
        </tr>
<?php endforeach; ?>
        <tr>
            <td>
                <?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save'); ?>\n"; ?>
            </td>
        </tr>
    </table>

    <?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->