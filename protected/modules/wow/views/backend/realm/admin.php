<?php
$this->breadcrumbs=array(
    'Realmlists'=>array('index'),
    'Manage',
);

?>

<h1>Manage Realmlists</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'realmlist-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'name',
        'address',
        'port',
        'timezone',
        'allowedSecurityLevel',
        'population',
        'realmbuilds',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
