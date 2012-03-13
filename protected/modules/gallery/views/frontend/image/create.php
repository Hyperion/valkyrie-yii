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
<div class="row fileupload-buttonbar">
    <div class="span7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <span><i class="icon-plus icon-white"></i> Выберите файлы...</span>
            <input type="file" name="files[]" multiple>
        </span>
        <button type="submit" class="btn btn-primary start">
            <i class="icon-upload icon-white"></i> Старт
        </button>
        <button type="reset" class="btn btn-warning cancel">
            <i class="icon-ban-circle icon-white"></i> Отмена
        </button>
        <button type="button" class="btn btn-danger delete">
            <i class="icon-trash icon-white"></i> Удалить
        </button>
        <input type="checkbox" class="toggle">
    </div>
    <div class="span5">
        <!-- The global progress bar -->
        <div class="progress progress-success progress-striped active fade">
            <div class="bar" style="width:0%;"></div>
        </div>
    </div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('bootstrap.widgets.BootModal', array(
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
    <a class="btn btn-primary modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
    <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a>
    <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
</div>
<?php $this->endWidget(); ?>

<?php
$this->ajaxOptions = array('successCallback' => 'js:function(d){$("#ImageParamsForm_album_id").append($("<option>").val(d.model.id).text(d.model.name).attr({selected:"selected"}));ajaxDialog.close();}');
?>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name">{%=file.name%}</td>
        <td class="size">{%=o.formatFileSize(file.size)%}</td>
        {% if (file.error) { %}
        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
        <td>
            <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
        </td>
        <td class="start">{% if (!o.options.autoUpload) { %}
            <button class="btn btn-primary">
                <i class="icon-upload icon-white"></i> {%=locale.fileupload.start%}
            </button>
            {% } %}</td>
        {% } else { %}
        <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i> {%=locale.fileupload.cancel%}
            </button>
            {% } %}</td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
        <td></td>
        <td class="name">{%=file.name%}</td>
        <td class="size">{%=o.formatFileSize(file.size)%}</td>
        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
        <td class="preview">{% if (file.thumbnail_url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
        <td class="name">
            <ul style="list-style: none; margin: 0px;">
                <li>
                    <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                </li>
                <li>Ссылка для просмотра изображения:</li>
                <li><input type="text" value="{%=file.view_url%}" style="width: 100%" /></li>
                <li>Прямая ссылка на изображение:</li>
                <li><input type="text" value="{%=file.absolute_url%}" style="width: 100%" /></li>
                <li>Ссылка на уменьшенное изображение:</li>
                <li><input type="text" value="{%=file.thumb_absolute_url%}" style="width: 100%" /></li>
                <li>BBCode для форума: Превью, увеличение по клику</li>
                <li><input type="text" value="{%=file.bb_code%}" style="width: 100%" /></li>
                <li>HTML-код для сайта: Превью, увеличение по клику</li>
                <li><input type="text" value="{%=file.html_code%}" style="width: 100%" /></li>
            </p>
        </ul>
    </td>
    <td class="size">{%=o.formatFileSize(file.size)%}</td>
    <td colspan="2"></td>
    {% } %}
    <td class="delete">
        <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
            <i class="icon-trash icon-white"></i> {%=locale.fileupload.destroy%}
        </button>
        <input type="checkbox" name="delete" value="1">
    </td>
</tr>
{% } %}
</script>
<?php
if(Yii::app()->request->enableCsrfValidation)
{
    $js = array();
    $options['csrfTokenName'] = CJavaScript::encode(Yii::app()->request->csrfTokenName);
    $options['csrfToken']     = CJavaScript::encode(Yii::app()->request->csrfToken);
    foreach($options as $key => $value)
        $js[] = "{$key}:{$value}";
    $js   = '{'.implode(',', $js).'}';
}
else
    $js   = '';
$this->cs->registerScript('FileUpload', "$('#fileupload').fileupload({$js});", CClientScript::POS_END);
?>
