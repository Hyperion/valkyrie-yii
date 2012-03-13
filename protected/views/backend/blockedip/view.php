<?php
$this->breadcrumbs = array(
    'Черный список IP' => array('admin'),
    $model->mask,
);
?>
<?php
$this->widget('BootDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'mask',
    ),
));
?>
