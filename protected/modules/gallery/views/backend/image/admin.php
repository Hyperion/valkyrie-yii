<?php
$this->breadcrumbs = array(
    'Фотографии' => array('admin'),
    'Управление',
);
?>
<div class="alert alert-block alert-success" style="display: none"></div>

<h1>Управление фотографиями</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>

<?php
echo CHtml::link('<i class="icon-white icon-plus"></i> Добавить изображение', array('create'), array(
    'class'                    => 'ajax-dialog-create btn-primary btn',
    'data-ajax-dialog-title' => Yii::t('app', 'Create a new image'),
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
            'name'  => 'image',
            'value' => '"<div class=\"thumbnail\">".CHtml::image($data->thumb_url)."<h5>".$data->image."</h5></div>"',
            'type'  => 'raw',
        ),
        array(
            'name'  => 'username',
            'value' => '($data->user) ? CHtml::link($data->user->username, array("/user/user/view", "id"   => $data->user_id)) : Yii::app()->user->guestName',
            'type'  => 'raw',
        ),
        array(
            'name'  => 'albumname',
            'value' => '($data->album) ? CHtml::link($data->album->name, array("/gallery/album/view", "id"   => $data->album_id)) : "Не задан"',
            'type'  => 'raw',
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
                        'data-ajax-dialog-title' => Yii::t('app', 'Update image'),
                    ),
                ),
                'view'                     => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Preview image'),
                    ),
                )
            ),
        ),
    ),
));
?>

<?php $this->ajaxLinks[] = '.ajax-dialog-create'; ?>