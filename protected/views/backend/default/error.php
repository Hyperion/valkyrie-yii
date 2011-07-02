<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
    'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="notification error png_bg">
<div><?php echo CHtml::encode($message); ?></div>
</div>
