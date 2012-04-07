<?php
$this->beginWidget('BootActiveForm', array(
    'type' => 'horizontal',
));
?>
Вы действительно хотите подать жалобу на изображение?
<br />
<div class="control-group">
    <label class="control-label" for="text">Текст жалобы</label>
    <div class="controls">
        <input type="text" class="input-xlarge" id="text" name="text">
    </div>
</div>
<?php $this->endWidget(); ?>