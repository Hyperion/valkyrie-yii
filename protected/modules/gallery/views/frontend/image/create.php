<?php
$this->pageTitle = Yii::app()->name;
Yii::app()->clientScript->registerScript('params', "
$('.params-button').click(function(){
    $('.params').toggle(300);
});
$(':checkbox').bind('click', function() {
    var next = $(this).parents('.control-group').next();
    if($(this).attr('checked')) {
        next.show(300);
    } else {
        next.hide(300);
    }
});
$('.slider').bind('slide', function(event, ui){
    $(this).parent().find('span').html(ui.value);
});
");
?>

<h1>Загрузка изображений</h1>
<h4><?php echo CHtml::link('Показать дополнительные опции', '#', array('class' => 'params-button')); ?></h4>

<?php
$form   = $this->beginWidget('BootActiveForm', array(
    'type'        => 'horizontal',
    'id'          => 'fileupload',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
?>
<br />
<div class="params well" style="display:none">
    <?php echo $form->checkboxRow($model, 'use_watermark'); ?>
    <div id="watermark-row" <?php if(!$model->use_watermark): ?> style="display:none"<?php endif; ?>>
        <?php echo $form->textFieldRow($model, 'watermark'); ?>
        <div class="control-group">
            <?php echo $form->label($model, 'watermark_color', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('application.extensions.colorpicker.EColorPicker', array(
                    'name'    => 'ImageParamsForm[watermark_color]',
                    'mode'    => 'textfield',
                    'value'   => $model->watermark_color,
                    'fade'    => false,
                    'slide'   => false,
                    'curtain' => true,
                    )
                );
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'watermark_font', $model->fonts); ?>
        <?php echo $form->textFieldRow($model, 'watermark_size'); ?>
        <?php echo $form->textFieldRow($model, 'watermark_left'); ?>
        <?php echo $form->textFieldRow($model, 'watermark_top'); ?>
        <div class="control-group">
            <?php echo $form->label($model, 'watermark_alfa', array('class' => 'control-label')); ?>
            <div class="controls">
                Текущее значение: <span><?php echo $model->watermark_alfa; ?></span>%
                <?php
                $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                    'model'       => $model,
                    'htmlOptions' => array('class'     => 'slider'),
                    'attribute' => 'watermark_alfa',
                    'options'   => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <?php echo $form->checkboxRow($model, 'use_resize'); ?>
    <div class="control-group" id="resize-row"<?php if(!$model->use_resize): ?> style="display:none"<?php endif; ?>>
        <?php echo $form->label($model, 'resize', array('class' => 'control-label')); ?>
        <div class="controls">
            Текущее значение: <span><?php echo $model->resize; ?></span>
            <?php
            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                'model'       => $model,
                'htmlOptions' => array('class'     => 'slider'),
                'attribute' => 'resize',
                'options'   => array(
                    'min' => 150,
                    'max' => 800,
                ),
            ));
            ?>
        </div>
    </div>
    <?php echo $form->checkboxRow($model, 'use_thumb_resize'); ?>
    <div class="control-group" <?php if(!$model->use_thumb_resize): ?> style="display:none"<?php endif; ?>>
        <?php echo $form->label($model, 'thumb_resize', array('class' => 'control-label')); ?>
        <div class="controls">
            Текущее значение: <span><?php echo $model->thumb_resize; ?></span>
            <?php
            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                'model'       => $model,
                'htmlOptions' => array('class'     => 'slider'),
                'attribute' => 'thumb_resize',
                'options'   => array(
                    'min' => 30,
                    'max' => 300,
                ),
            ));
            ?>
        </div>
    </div>
    <?php if(!Yii::app()->user->isGuest): ?>
        <?php
        echo $form->dropDownListRow(
            $model, 'album_id', CHtml::listData(
                Album::model()->findAll('user_id = :user_id', array('user_id' => Yii::app()->user->id)), 'id', 'name'
            ), array('empty' => array(0 => 'Нет'))
        );
        ?>
        <?php
        echo CHtml::link('<i class="icon-white icon-plus"></i> Добавить альбом', array('/gallery/album/create'), array(
            'class'                    => 'ajax-dialog-create btn-primary btn',
            'data-update-dialog-title' => Yii::t('app', 'Create a new album'),
        ));
        ?>
        <?php $this->ajaxLinks = array_merge($this->ajaxLinks, array('.ajax-dialog-create')); ?>
    <?php endif; ?>

</div>
<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <?php $this->widget('application.components.widgets.BUploadTable', array('info' => array(
        array('label' => 'Ссылка для просмотра изображения:', 'type' => 'input', 'attribute' => 'view_url'),
        array('label' => 'Прямая ссылка на изображение:', 'type' => 'input', 'attribute' => 'absolute_url'),
        array('label' => 'Ссылка на уменьшенное изображение:', 'type' => 'input', 'attribute' => 'thumb_absolute_url'),
        array('label' => 'BBCode для форума: Превью, увеличение по клику', 'type' => 'input', 'attribute' => 'bb_code'),
        array('label' => 'HTML-код для сайта: Превью, увеличение по клику', 'type' => 'input', 'attribute' => 'html_code'),
    )));
    ?>
<?php $this->endWidget(); ?>
<?php $this->widget('application.components.widgets.BBootGallery'); ?>

<?php
$this->ajaxOptions = array('successCallback' => 'js:function(d){$("#ImageParamsForm_album_id").append($("<option>").val(d.model.id).text(d.model.name).attr({selected:"selected"}));ajaxDialog.close();}');
?>