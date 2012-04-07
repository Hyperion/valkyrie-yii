<?php
$this->breadcrumbs = array('Галерея' => array('index'), 'Статистика');
?>

<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'    => 'tabs',
    'stacked' => false,
    'items'   => array(
        array('label' => 'Настройки', 'url'   => array('/gallery/default')),
        array('label' => 'Статистика', 'url'   => array('/gallery/default/statistic'), 'active' => true),
    ),
));
?>

<h1>Статистика галереи</h1>
