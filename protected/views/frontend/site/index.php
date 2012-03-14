<?php if(count($files)): ?>
<div class="slider-cont">
    <div id="slider">
        <ul>
            <?php foreach($files as $file): ?>
                <li><img src="<?php echo $file->url; ?>" alt="" /></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script>
    $("#slider").easySlider();
</script>
<?php endif; ?>
<?php echo Yii::app()->config->get('main_page'); ?>