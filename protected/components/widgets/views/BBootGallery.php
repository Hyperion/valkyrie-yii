<?php if(!empty($images)): ?>
<?php
$this->widget('BootListView', array(
    'dataProvider' => $images,
    'itemView'     => '_thumb',
    'htmlOptions'  => array('data-toggle' => 'modal-gallery', 'data-target' => '#modal-gallery', 'class'       => 'media-grid'),
));
?>
<?php endif; ?>

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
    <?php if($showViewLink): ?>
    <a class="btn modal-link"><i class="icon-picture"></i> Просмотр</a>
    <?php endif; ?>
</div>
<?php $this->endWidget(); ?>