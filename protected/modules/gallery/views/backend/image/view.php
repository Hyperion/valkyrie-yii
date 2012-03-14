<?php

$this->widget('BootDetailView', array(
    'data'       => $model,
    'attributes' => array(
        array(
            'value' => CHtml::image($model->url, '', array('class' => 'full')),
            'type'  => 'raw',
        ),
        'id',
        'image',
        'width',
        'height',
        'size',
        'description',
        array(
            'name'  => 'user_id',
            'value' => ($model->user_id) ? CHtml::link($model->user->username, array('/user/user/view', 'id'   => $model->user_id)) : Yii::app()->user->guestName . " ($model->user_guid)",
            'type' => 'raw',
        ),
        array(
            'name'  => 'album_id',
            'value' => ($model->album_id) ? CHtml::link($model->album->name, array('/gallery/album/view', 'id'   => $model->album_id)) : '',
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