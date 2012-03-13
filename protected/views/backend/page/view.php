<?php
$this->breadcrumbs = array(
    'Страницы' => array('admin'),
    $model->title,
);
?>
<h1 class="title"><?php echo $model->title; ?></h1>
<div>
    <?php echo $model->text; ?>	
</div>
