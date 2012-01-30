<?php
$this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Generate items'),
);
?>

<h2><?php echo Rights::t('core', 'Generate items'); ?></h2>

<p><?php echo Rights::t('core', 'Please select which items you wish to generate.'); ?></p>

<?php $form    = $this->beginWidget('CActiveForm'); ?>

<div class="span">

    <table class="items generate-item-table" border="0" cellpadding="0" cellspacing="0">

        <tbody>

            <tr class="application-heading-row">
                <th colspan="3"><?php echo Rights::t('core', 'Application'); ?></th>
            </tr>

            <?php
            $this->renderPartial('_generateItems', array(
                'model'                   => $model,
                'form'                    => $form,
                'items'                   => $items,
                'existingItems'           => $existingItems,
                'displayModuleHeadingRow' => true,
                'basePathLength'          => strlen(Yii::app()->basePath),
            ));
            ?>

        </tbody>

    </table>

</div>

<div class="span">

    <?php
    echo CHtml::link(Rights::t('core', 'Select all'), '#', array(
        'onclick' => "jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
        'class'   => 'selectAllLink'));
    ?>
    /
    <?php
    echo CHtml::link(Rights::t('core', 'Select none'), '#', array(
        'onclick' => "jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
        'class'   => 'selectNoneLink'));
    ?>

</div>

<div class="actions">

    <?php echo CHtml::submitButton(Rights::t('core', 'Generate'), array('class' => 'btn primary')); ?>

</div>

<?php $this->endWidget(); ?>

</div>