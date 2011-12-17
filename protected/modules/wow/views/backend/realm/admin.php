<?php
$this->breadcrumbs = array(
    'Realmlists' => array('index'),
    'Manage',
);
?>

<h1>Manage Realmlists</h1>
<div class="bloc">
    <div class="title">Игровые миры</div>
    <div class="content">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'realmlist-grid',
            'pagerCssClass' => 'pagination',
            'pager' => array(
                'class' => 'CLinkPager',
                'cssFile' => false,
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'header' => false,
            ),
            'cssFile' => false,
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                'address',
                'port',
                'allowedSecurityLevel',
                'realmbuilds',
                array(
                    'class' => 'CButtonColumn',
                    'updateButtonImageUrl' => Yii::app()->request->baseUrl . '/img/icons/actions/edit.png',
                    'viewButtonImageUrl' => Yii::app()->request->baseUrl . '/img/icons/actions/view.png',
                    'deleteButtonImageUrl' => Yii::app()->request->baseUrl . '/img/icons/actions/delete.png',
                    'header' => 'Actions',
                ),
            ),
        ));
        ?>
    </div>
</div>
