<?php
$this->breadcrumbs = array(
    WowModule::t('Databases') => array('admin'),
    Yii::t('app', 'Manage'),
);
?>

<h1>Manage Realmlists</h1>
<?php
$this->widget('BootGridView', array(
    'id'           => 'realmlist-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'name',
        'host',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>