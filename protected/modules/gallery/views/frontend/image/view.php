<?php if(Yii::app()->user->checkAccess('ManipulateOwnImage')): ?>
    <div class="well controls">
        <?php
        echo CHtml::link('<i class="icon-white icon-edit"></i> Редактировать', array('update', 'id' => $model->id), array(
            'class'                    => 'btn-warning btn update',
            'data-ajax-dialog-title' => Yii::t('app', 'Update image')));
        ?>
        <?php
        echo CHtml::link('<i class="icon-white icon-trash"></i> Удалить', array('delete', 'id' => $model->id), array(
            'class'                    => 'btn-danger btn delete',
            'data-ajax-dialog-title' => Yii::t('app', 'Delete image')));
        ?>
    </div>
    <?php $this->ajaxLinks = array_merge($this->ajaxLinks, array('.update' , '.delete')); ?>
<?php endif; ?>
<?php
$this->widget('BootDetailView', array(
    'data'       => $model,
    'attributes' => array(
        array(
            'name'  => 'image',
            'value' => CHtml::image($model->url, '', array('class' => 'full')),
            'type'  => 'raw',
        ),
        'width',
        'height',
        'size',
        'description',
        array(
            'name'  => 'user_id',
            'value' => (is_object($model->user)) ? CHtml::link($model->user->username, array('/user/user/view', 'id'   => $model->user_id)) : Yii::app()->user->guestName,
            'type' => 'raw',
        ),
        array(
            'name'  => 'create_time',
            'value' => Yii::app()->locale->dateFormatter->formatDateTime($model->create_time, "long"),
            'type'  => 'raw',
        ),
        'visits',
    ),
));
?>