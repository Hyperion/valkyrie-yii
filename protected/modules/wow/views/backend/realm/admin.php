<?php
$this->breadcrumbs = array(
    'Realmlists' => array('index'),
    'Manage',
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
        'address',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>