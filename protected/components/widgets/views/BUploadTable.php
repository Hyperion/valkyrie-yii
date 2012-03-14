<div class="row fileupload-buttonbar">
    <div class="span7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <span><i class="icon-plus icon-white"></i> Добавить файлы</span>
            <input type="file" name="files[]" multiple>
        </span>
        <button type="submit" class="btn btn-primary start">
            <i class="icon-upload icon-white"></i> Загрузить
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
<table class="table table-striped">
    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
        <?php foreach($files as $file): ?>
            <tr class="template-download">
                <td class="preview">
                    <a href="<?php echo $file->url; ?>" title="<?php echo $file->file; ?>" rel="gallery" download="<?php echo $file->file; ?>"><img src="<?php echo $file->thumbnail_url; ?>"></a>
                </td>
                <td class="name">
                    <ul style="list-style: none; margin: 0px;">
                        <li>
                            <a href="<?php echo $file->url; ?>" title="<?php echo $file->file; ?>" rel="gallery" download="<?php echo $file->file; ?>"><?php echo $file->file; ?></a>
                        </li>
                    </ul>
                </td>
                <td class="size"></td>
                <td colspan="2"></td>
                <td class="delete">
                    <button class="btn btn-danger" data-type="POST" data-url="<?php echo $this->getController()->createAbsoluteUrl('delete', array('id' => $file->id)); ?>">
                        <i class="icon-trash icon-white"></i> Удалить
                    </button>
                    <input type="checkbox" name="delete" value="1">
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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
                <?php foreach($info as $param): ?>
                    <li><?php echo $param['label']; ?></li>
                    <li>
                        <?php if($param['type'] == 'input'): ?>
                            <input type="text" value="{%=file.<?php echo $param['attribute']; ?>%}" style="width: 100%" />
                        <?php else: ?>
                            {%=file.<?php echo $param['attribute']; ?>%}
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
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