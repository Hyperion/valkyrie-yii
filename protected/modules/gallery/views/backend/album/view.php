<?php
$this->breadcrumbs = array(
    'Albums' => array('admin'),
    $model->name,
);
?>

<h1>Просмотр альбома "<?php echo $model->name; ?>"</h1>

<?php
$this->widget('BootDetailView', array(
    'data'       => $model,
    'attributes' => array(
        array(
            'name'  => 'cover_id',
            'value' => (is_object($model->cover)) ? CHtml::image($model->cover->thumb_url) : "Не задана",
            'type'  => 'raw',
        ),
        'name',
        'description',
        array(
            'name'  => 'user_id',
            'value' => ($model->user_id) ? CHtml::link($model->user->username, array('/user/user/view', 'id'   => $model->user_id)) : Yii::app()->user->guestName . " ($model->user_guid)",
            'type' => 'raw',
        ),
        array(
            'name'  => 'create_time',
            'value' => Yii::app()->locale->dateFormatter->formatDateTime($model->create_time, "long"),
            'type'  => 'raw',
        ),
        array(
            'name' => 'visible',
            'value' => ($model->visible) ? 'Да' : 'Нет',
        )
    ),
));
?>

<h4>Изображения в этом альбоме:</h4>

<?php $this->widget('application.components.widgets.BBootGallery', array('showViewLink' => true, 'images' => $model->images())); ?>