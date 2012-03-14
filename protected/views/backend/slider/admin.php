<?php
$this->breadcrumbs = array(
    'Слайдер' => array('admin'),
    'Управление',
);
?>

<?php $this->pageTitle = Yii::app()->name; ?>

<h1>Управление слайдером</h1>
<form id="fileupload" action="<?php echo $this->createUrl('upload'); ?>" method="POST" enctype="multipart/form-data">
    <?php $this->widget('application.components.widgets.BUploadTable', array('files' => $files));
    ?>
</form>

<?php $this->widget('application.components.widgets.BBootGallery'); ?>