<?php
$this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments'),
);
$this->menu = array_merge($this->menu, array(
    array(
        'label' => Rights::t('core', 'Assignments'),
        'url'   => array('assignment/view'),
        'itemOptions' => array('class' => 'item-assignments'),
    ),
    array(
        'label' => Rights::t('core', 'Permissions'),
        'url'   => array('authItem/permissions'),
        'itemOptions' => array('class' => 'item-permissions'),
    ),
    array(
        'label' => Rights::t('core', 'Roles'),
        'url'   => array('authItem/roles'),
        'itemOptions' => array('class' => 'item-roles'),
    ),
    array(
        'label' => Rights::t('core', 'Tasks'),
        'url'   => array('authItem/tasks'),
        'itemOptions' => array('class' => 'item-tasks'),
    ),
    array(
        'label' => Rights::t('core', 'Operations'),
        'url'   => array('authItem/operations'),
        'itemOptions' => array('class' => 'item-operations'),
    ),
        ));
?>

<h2><?php echo Rights::t('core', 'Assignments'); ?></h2>

<p>
    <?php echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
</p>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $dataProvider,
    'template'     => "{items}\n{pager}",
    'emptyText'    => Rights::t('core', 'No users found.'),
    'htmlOptions'  => array('class'   => 'grid-view assignment-table'),
    'columns' => array(
        array(
            'name'        => 'name',
            'header'      => Rights::t('core', 'Name'),
            'type'        => 'raw',
            'htmlOptions' => array('class' => 'name-column'),
            'value' => '$data->getAssignmentNameLink()',
        ),
        array(
            'name'        => 'assignments',
            'header'      => Rights::t('core', 'Roles'),
            'type'        => 'raw',
            'htmlOptions' => array('class' => 'role-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
        ),
        array(
            'name'        => 'assignments',
            'header'      => Rights::t('core', 'Tasks'),
            'type'        => 'raw',
            'htmlOptions' => array('class' => 'task-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
        ),
        array(
            'name'        => 'assignments',
            'header'      => Rights::t('core', 'Operations'),
            'type'        => 'raw',
            'htmlOptions' => array('class' => 'operation-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
        ),
    )
));
?>