<?php
$this->breadcrumbs = array(
    'Characters' => array('admin'),
);
?>

<h1>Manage Characters</h1>
<div class="bloc">
    <div class="title">Персонажи</div>
    <div class="content">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'characters-grid',
        'pagerCssClass' => 'pagination',
        'pager' => array(
            'class'=>'CLinkPager',
            'cssFile' => false,
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
            'header' => false,
        ),
        'cssFile' => false,
        'dataProvider' => $model->search(true),
        'filter' => $model,
        'columns' => array(
            'guid',
            'name',
            array(
                'name' => 'realm',
                'sortable' => false,
            ),
            array(
                'class' => 'CButtonColumn',
                'updateButtonUrl' => 'array("/wow/character/update/", "realm" => $data->realm, "id" => $data->guid)',
                'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/edit.png',
                'viewButtonUrl' => 'array("/wow/character/view/", "realm" => $data->realm, "id" => $data->guid)',
                'viewButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/view.png',
                'deleteButtonUrl' => 'array("/wow/character/delete/", "realm" => $data->realm, "id" => $data->guid)',
                'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/img/icons/actions/delete.png',
                'header' => 'Actions',
            ),
        ),
    ));
    ?>
    </div>
</div>
