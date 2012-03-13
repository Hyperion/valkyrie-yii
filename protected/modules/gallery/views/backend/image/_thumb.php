<div class="thumbnail">
    <?php
    echo CHtml::link(
        CHtml::image(
            $data->thumb_url, $data->image
        ), $data->url, array(
        'title'    => $data->image,
        'rel'      => 'gallery',
        )
    );
    ?>
    <h5>
<?php echo CHtml::link($data->image, array('/gallery/image/view', 'id' => $data->id)); ?>
    </h5>
</div>
