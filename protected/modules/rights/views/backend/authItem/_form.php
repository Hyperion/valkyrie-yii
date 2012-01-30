<div class="span" style="width: 50%">

    <?php if ($model->scenario === 'update'): ?>
        <h3><?php echo Rights::getAuthItemTypeName($model->type); ?></h3>
    <?php endif; ?>

    <?php $form = $this->beginWidget('BootActiveForm'); ?>

    <?php
    echo $form->textFieldRow($model, 'name', array(
        'maxlength' => 255,
        'class'     => 'text-field',
        'hint'      => Rights::t('core', 'Do not change the name unless you know what you are doing.')
    ));
    ?>


    <?php
    echo $form->textFieldRow($model, 'description', array(
        'maxlength' => 255,
        'class'     => 'text-field',
        'hint'      => Rights::t('core', 'A descriptive name for this item.')
    ));
    ?>

    <?php if (Rights::module()->enableBizRule === true): ?>

        <?php
        echo $form->textFieldRow($model, 'bizRule', array(
            'maxlength' => 255,
            'class'     => 'text-field',
            'hint'      => Rights::t('core', 'Code that will be executed when performing access checking.')
        ));
        ?>

    <?php endif; ?>
    <?php if (Rights::module()->enableBizRule === true && Rights::module()->enableBizRuleData): ?>

        <?php
        echo $form->textFieldRow($model, 'data', array(
            'maxlength' => 255,
            'class'     => 'text-field',
            'hint'      => Rights::t('core', 'Additional data available when executing the business rule.')
        ));
        ?>

    <?php endif; ?>

    <div class="actions">
    <?php echo CHtml::submitButton(Rights::t('core', 'Save'), array('class' => 'btn primary')); ?> | <?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl); ?>
    </div>

<?php $this->endWidget(); ?>

</div>