<li><?php
echo CHtml::link(
    CHtml::image(
        $data->thumb_url, $data->image
    ), $data->url, array(
    'title'    => $data->image,
    'rel'      => 'gallery',
    'data-link' => $this->controller->createUrl('/gallery/image/view', array('id' => $data->id)),
    )
);
?>
</li>
