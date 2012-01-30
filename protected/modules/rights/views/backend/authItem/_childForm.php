<?php $form = $this->beginWidget('BootActiveForm'); ?>

<?php echo $form->dropDownListRow($model, 'itemname', $itemnameSelectOptions); ?>

<div class="actions">
    <?php echo CHtml::submitButton(Rights::t('core', 'Add'), array('class' => 'btn primary')); ?>
</div>

<?php $this->endWidget(); ?>