<?php
$this->breadcrumbs=array(
	'Альбомы'=>array('index'),
	$model->name,
);

?>

<h1>Просмотр альбома <?php echo $model->name; ?></h1>
<?php if(Yii::app()->user->checkAccess('ManipulateOwnAlbum')): ?>
    <div class="well controls">
        <?php
        echo CHtml::link('<i class="icon-white icon-edit"></i> Редактировать', array('update', 'id' => $model->id), array(
            'class'                    => 'btn-warning btn update',
            'data-update-dialog-title' => Yii::t('app', 'Update album')));
        ?>
        <?php
        echo CHtml::link('<i class="icon-white icon-trash"></i> Удалить', array('delete', 'id' => $model->id), array(
            'class'                    => 'btn-danger btn delete',
            'data-update-dialog-title' => Yii::t('app', 'Delete album')));
        ?>
    </div>
    <?php
    $this->widget('application.components.widgets.BUpdateDialog', array(
        'target_links' => array('.update' , '.delete'),
    ));
    ?>
<?php endif; ?>
<?php
$this->widget('BootListView', array(
    'dataProvider' => $model->images(),
    'itemView'     => '/image/_thumb',
    'htmlOptions' => array('data-toggle' => 'modal-gallery', 'data-target' => '#modal-gallery', 'class' => 'media-grid'),
));
?>

<?php
$this->beginWidget('BootModal', array(
    'id'          => 'modal-gallery',
    'htmlOptions' => array('class'       => 'modal modal-gallery hide fade'),
));
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3 class="modal-title"></h3>
</div>
<div class="modal-body"><div class="modal-image"></div></div>
<div class="modal-footer">
    <a class="btn btn-primary modal-next"><i class="icon-arrow-right icon-white"></i></a>
    <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i></a>
    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Слайдшоу</a>
    <a class="btn btn-warning modal-download" target="_blank"><i class="icon-white icon-download"></i> Загрузка</a>
    <a class="btn modal-link"><i class="icon-picture"></i> Просмотр</a>
</div>
<?php $this->endWidget(); ?>