<?php
$this->breadcrumbs = array(
    'Characters' => array('admin'),
);
?>

<h1>Manage Characters</h1>
    <?php
    $this->widget('BootGridView', array(
        'id' => 'characters-grid',
        'dataProvider' => $model->search(true),
        'filter' => $model,
        'columns' => array(
            'guid',
            'name',
            'account',
            array(
                'class' => 'CButtonColumn',
                'updateButtonUrl' => 'array("/wow/character/update/", "realm" => $data->realm, "id" => $data->guid)',
                'viewButtonUrl' => 'array("/wow/character/view/", "realm" => $data->realm, "id" => $data->guid)',
                'deleteButtonUrl' => 'array("/wow/character/delete/", "realm" => $data->realm, "id" => $data->guid)',
            ),
        ),
    ));

