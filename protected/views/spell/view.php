<?php
$this->breadcrumbs=array(
    'Spells' => array('/spell'),
    $model->spellname_loc0 => ''
);
?>

<div class="info">
<div class="title"> 
<h2><?php echo $model->spellname_loc0; ?></h2> 
</div>
<div class="item-detail">
<?php $this->renderPartial('_view', array('model' => $model, 'data' => false)); ?>
</div>
</div>
