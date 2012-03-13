<?php
$this->breadcrumbs = array(
    'Черный список IP' => array('admin'),
    'Управление',
);
?>
<div class="alert alert-block alert-success" style="display: none"></div>

<h1>Управление черным списком IP</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>

<?php
echo CHtml::link('<i class="icon-white icon-plus"></i> Добавить IP в черный список', array('create'), array(
    'class'                    => 'ajax-dialog-create btn-primary btn',
    'data-ajax-dialog-title' => Yii::t('app', 'Add IP'),
));
?>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'mask',
        array(
            'class'   => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'delete' => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Delete confirmation'),
                    ),
                ),
                'update'                   => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Update IP'),
                    ),
                ),
            ),
        ),
    ),
));
?>

<?php $this->ajaxLinks[] = '.ajax-dialog-create'; ?>
