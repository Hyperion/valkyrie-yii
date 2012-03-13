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

<?php
$this->beginWidget('bootstrap.widgets.BootModal', array(
    'id'          => 'modal-gallery',
    'htmlOptions' => array('class' => 'modal modal-gallery hide fade'),
));
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3 class="modal-title"></h3>
</div>
<div class="modal-body"><div class="modal-image"></div></div>
<div class="modal-footer">
    <a class="btn btn-primary modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
    <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a>
    <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
</div>
<?php $this->endWidget(); ?>

<h4>Изображения в этом альбоме:</h4>

<?php
$this->widget('BootThumbs', array(
    'dataProvider' => $model->images(),
    'itemView'     => '/image/_thumb',
    'htmlOptions' => array('data-toggle' => 'modal-gallery', 'data-target' => '#modal-gallery'),
));
?>