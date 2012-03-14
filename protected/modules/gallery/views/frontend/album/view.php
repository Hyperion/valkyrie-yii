<?php
$this->breadcrumbs = array(
    'Альбомы' => array('index'),
    $model->name,
);
?>

<h1>Просмотр альбома <?php echo $model->name; ?></h1>
<?php if(Yii::app()->user->checkAccess('ManipulateOwnAlbum')): ?>
    <div class="well controls">
        <?php
        echo CHtml::link('<i class="icon-white icon-edit"></i> Редактировать', array('update', 'id' => $model->id), array(
            'class'                  => 'btn-warning btn update',
            'data-ajax-dialog-title' => Yii::t('app', 'Update album')));
        ?>
        <?php
        echo CHtml::link('<i class="icon-white icon-trash"></i> Удалить', array('delete', 'id' => $model->id), array(
            'class'                  => 'btn-danger btn delete',
            'data-ajax-dialog-title' => Yii::t('app', 'Delete album')));
        ?>
    </div>
    <?php $this->ajaxLinks = array_merge($this->ajaxLinks, array('.update', '.delete')); ?>
<?php endif; ?>

<?php $this->widget('application.components.widgets.BBootGallery', array('showViewLink' => true, 'images' => $model->images())); ?>