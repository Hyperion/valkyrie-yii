<?php
$this->breadcrumbs = array(
    'Страницы' => array('admin'),
    'Управление',
);

?>


<h1>Управление страницами</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'title',
        'url',
        array(
            'class'    => 'CButtonColumn',
        ),
    ),
));
?>
