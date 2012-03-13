<?php
$this->breadcrumbs = array(
    'Альбомы' => array('admin'),
    'Управление',
);
?>
<div class="alert alert-block alert-success" style="display: none"></div>

<h1>Управление альбомами</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>

<?php
echo CHtml::link('<i class="icon-white icon-plus"></i> Добавить альбом', array('create'), array(
    'class'                    => 'ajax-dialog-create btn-primary btn',
    'data-ajax-dialog-title' => Yii::t('app', 'Create a new album'),
));
?>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'filter'      => false,
            'htmlOptions' => array('width' => 50),
        ),
        array(
            'name'  => 'name',
            'value' => '($data->cover) ? "<div class=\"thumbnail\">".CHtml::image($data->cover->thumb_url)."<h5>".$data->name."</h5></div>" : ""',
            'type'  => 'raw',
        ),
        array(
            'name'  => 'username',
            'value' => 'CHtml::link($data->user->username, array("/user/user/view", "id"   => $data->user_id))',
            'type'  => 'raw',
        ),
        array(
            'name'  => 'visible',
            'value' => '($data->visible) ? "Да" : "Нет"',
            'filter' => array('Нет', 'Да'),
        ),
        array(
            'class'   => 'CButtonColumn',
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
                        'data-ajax-dialog-title' => Yii::t('app', 'Update album'),
                    ),
                ),
                'view'                     => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Preview album'),
                    ),
                )
            ),
        ),
    ),
));
?>

<?php $this->ajaxLinks[] = '.ajax-dialog-create'; ?>