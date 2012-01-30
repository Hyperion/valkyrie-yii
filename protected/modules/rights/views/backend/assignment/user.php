<?php
$this->breadcrumbs = array(
    'Rights'                         => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments') => array('assignment/view'),
    $model->getName(),
);
?>

<h2><?php
echo Rights::t('core', 'Assignments for :username', array(
    ':username' => $model->getName()
));
?></h2>
<div class="row">
    <div style="width: 50%" class="span">

        <?php
        $this->widget('BootGridView', array(
            'dataProvider' => $dataProvider,
            'template'     => '{items}',
            'hideHeader'   => true,
            'emptyText'    => Rights::t('core', 'This user has not been assigned any items.'),
            'htmlOptions'  => array('class'   => 'grid-view user-assignment-table mini'),
            'columns' => array(
                array(
                    'name'        => 'name',
                    'header'      => Rights::t('core', 'Name'),
                    'type'        => 'raw',
                    'htmlOptions' => array('class' => 'name-column'),
                    'value' => '$data->getNameText()',
                ),
                array(
                    'name'        => 'type',
                    'header'      => Rights::t('core', 'Type'),
                    'type'        => 'raw',
                    'htmlOptions' => array('class' => 'type-column'),
                    'value' => '$data->getTypeText()',
                ),
                array(
                    'header'      => '&nbsp;',
                    'type'        => 'raw',
                    'htmlOptions' => array('class' => 'actions-column'),
                    'value' => '$data->getRevokeAssignmentLink()',
                ),
            )
        ));
        ?>

    </div>

    <div class="span">

        <h3><?php echo Rights::t('core', 'Assign item'); ?></h3>

        <?php if ($formModel !== null): ?>


                <?php
                $this->renderPartial('_form', array(
                    'model'                 => $formModel,
                    'itemnameSelectOptions' => $assignSelectOptions,
                ));
                ?>


        <?php else: ?>

            <p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>

            <?php endif; ?>

    </div>

</div>
